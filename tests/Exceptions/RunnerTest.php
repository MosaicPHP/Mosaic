<?php

// Will use two namespaces here to monkey patch the `error_get_last` function
namespace Fresco\Tests\Exceptions
{
    use ErrorException;
    use Fresco\Application;
    use Fresco\Contracts\Container\Container;
    use Fresco\Exceptions\Formatters\HtmlFormatter;
    use Fresco\Exceptions\Formatters\JsonFormatter;
    use Fresco\Exceptions\Handlers\LogHandler;
    use Fresco\Exceptions\Runner;

    class RunnerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var array|null
         */
        public static $error;

        /**
         * @var \Mockery\Mock
         */
        private $app;

        /**
         * @var \Mockery\Mock
         */
        private $container;

        /**
         * @var AppExceptionRunner
         */
        private $runner;

        public function setUp()
        {
            $this->app       = \Mockery::mock(Application::class);
            $this->container = \Mockery::mock(Container::class);

            $this->app->shouldReceive('getContainer')->andReturn($this->container);

            $this->runner = new AppExceptionRunner($this->app);
        }

        public function test_can_handle_error_when_error_reporting_is_enabled()
        {
            $this->setExpectedException(ErrorException::class, 'Error message');

            $this->runner->handleError(1, 'Error message');
        }

        public function test_error_handling_is_ignored_when_error_reporting_is_disabled()
        {
            error_reporting(false);

            $this->runner->handleError(1, 'Error message');
        }

        public function test_can_handle_exceptions()
        {
            $this->runner->addHandler(LogHandler::class);

            $handler = \Mockery::mock(LogHandler::class);
            $handler->shouldReceive('handle')->once();
            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);

            $formatter = \Mockery::mock(HtmlFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn('Some message');
            $this->container->shouldReceive('make')->with(HtmlFormatter::class)->once()->andReturn($formatter);

            $response = $this->runner->handleException(new \Exception('Some message'));

            $this->assertEquals('Some message', $response);
        }

        public function test_exception_handling_can_be_ignored()
        {
            $this->runner->addHandler(LogHandler::class);

            $this->container->shouldReceive('make')->with(LogHandler::class)->never();

            $formatter = \Mockery::mock(HtmlFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn('Some message');
            $this->container->shouldReceive('make')->with(HtmlFormatter::class)->once()->andReturn($formatter);

            $response = $this->runner->handleException(new \InvalidArgumentException('Some message'));

            $this->assertEquals('Some message', $response);
        }

        public function test_can_handle_exceptions_with_custom_formatter()
        {
            $this->runner->addHandler(LogHandler::class);
            $this->runner->setFormatter(JsonFormatter::class);

            $handler = \Mockery::mock(LogHandler::class);
            $handler->shouldReceive('handle')->once();
            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);

            $formatter = \Mockery::mock(JsonFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn(json_encode(['Some message']));
            $this->container->shouldReceive('make')->with(JsonFormatter::class)->once()->andReturn($formatter);

            $response = $this->runner->handleException(new \Exception('Some message'));

            $this->assertEquals(json_encode(['Some message']), $response);
        }

        public function test_can_handle_shutdown_when_no_errors_happened()
        {
            $this->runner->addHandler(LogHandler::class);
            $this->runner->setFormatter(JsonFormatter::class);

            $handler = \Mockery::mock(LogHandler::class);
            $handler->shouldReceive('handle')->never();

            $this->runner->handleShutdown();
        }

        public function test_can_handle_a_fatal_php_error_in_shutdown()
        {
            $handler   = \Mockery::mock(LogHandler::class);
            $formatter = \Mockery::mock(JsonFormatter::class);

            $this->runner->addHandler(LogHandler::class);
            $this->runner->setFormatter(JsonFormatter::class);

            $handler->shouldReceive('handle')->once()->with(\Mockery::on(function ($e) {
                return
                    $e instanceof ErrorException &&
                    $e->getMessage() == self::$error['message'] &&
                    $e->getCode() == self::$error['type'] &&
                    $e->getSeverity() == 0 &&
                    $e->getFile() == self::$error['file'] &&
                    $e->getLine() == self::$error['line'];
            }));

            $formatter->shouldReceive('render')->once()->andReturn('foo');

            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);
            $this->container->shouldReceive('make')->with(JsonFormatter::class)->once()->andReturn($formatter);

            self::$error = [
                'message' => 'foo',
                'type'    => 1337,
                'file'    => __FILE__,
                'line'    => 7,
            ];

            $this->runner->handleShutdown();
        }

        protected function tearDown()
        {
            \Mockery::close();
            self::$error = null;
        }
    }

    class AppExceptionRunner extends Runner
    {
        /**
         * @var array
         */
        protected $shouldNotHandle = [
            \InvalidArgumentException::class,
        ];
    }
}

namespace Fresco\Exceptions
{
    use Fresco\Tests\Exceptions\RunnerTest;

    function error_get_last()
    {
        return RunnerTest::$error ?: \error_get_last();
    }
}
