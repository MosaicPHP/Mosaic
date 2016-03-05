<?php

// Will use two namespaces here to monkey patch the `error_get_last` function
namespace Mosaic\Tests\Exceptions {

    use ErrorException;
    use Mosaic\Application;
    use Mosaic\Contracts\Container\Container;
    use Mosaic\Contracts\Http\Emitter;
    use Mosaic\Contracts\Http\ResponseFactory;
    use Mosaic\Exceptions\ErrorResponse;
    use Mosaic\Exceptions\Formatters\HtmlFormatter;
    use Mosaic\Exceptions\Formatters\JsonFormatter;
    use Mosaic\Exceptions\Handlers\LogHandler;
    use Mosaic\Exceptions\Runner;
    use Mosaic\Tests\ClosesMockeryOnTearDown;
    use Mockery\Mock;
    use Zend\Diactoros\Response\HtmlResponse;
    use Zend\Diactoros\Response\JsonResponse;

    class RunnerTest extends \PHPUnit_Framework_TestCase
    {
        use ClosesMockeryOnTearDown;

        /**
         * @var array|null
         */
        public static $error;

        /**
         * @var Mock
         */
        private $emitter;

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
            $this->emitter   = \Mockery::mock(Emitter::class);

            $this->app->shouldReceive('getContainer')->andReturn($this->container);

            $this->runner = new AppExceptionRunner($this->app, $this->emitter);
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
            $e = new \Exception('Some message');

            $this->runner->addHandler(LogHandler::class);

            $handler = \Mockery::mock(LogHandler::class);
            $handler->shouldReceive('handle')->once();
            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);

            $formatter = \Mockery::mock(HtmlFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn(ErrorResponse::fromException($e));
            $this->container->shouldReceive('make')->with(HtmlFormatter::class)->once()->andReturn($formatter);

            $this->container->shouldReceive('make')->with(ResponseFactory::class)->once()->andReturn(
                $factory = \Mockery::mock(ResponseFactory::class)
            );

            $htmlResponse = new \Mosaic\Http\Adapters\Psr7\Response(new HtmlResponse('Some message'));
            $factory->shouldReceive('make')->once()->andReturn($htmlResponse);

            $this->emitter->shouldReceive('emit')->with($htmlResponse)->once();

            $this->runner->handleException($e);
        }

        public function test_exception_handling_can_be_ignored()
        {
            $e = new \InvalidArgumentException('Some message');

            $this->runner->addHandler(LogHandler::class);

            $this->container->shouldReceive('make')->with(LogHandler::class)->never();

            $formatter = \Mockery::mock(HtmlFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn(ErrorResponse::fromException($e));
            $this->container->shouldReceive('make')->with(HtmlFormatter::class)->once()->andReturn($formatter);

            $this->container->shouldReceive('make')->with(ResponseFactory::class)->once()->andReturn(
                $factory = \Mockery::mock(ResponseFactory::class)
            );

            $htmlResponse = new \Mosaic\Http\Adapters\Psr7\Response(new HtmlResponse('Some message'));
            $factory->shouldReceive('make')->once()->andReturn($htmlResponse);

            $this->emitter->shouldReceive('emit')->with($htmlResponse)->once();

            $this->runner->handleException($e);
        }

        public function test_can_handle_exceptions_with_custom_formatter()
        {
            $e = new \Exception('Some message');

            $this->runner->addHandler(LogHandler::class);
            $this->runner->setFormatter(JsonFormatter::class);

            $handler = \Mockery::mock(LogHandler::class);
            $handler->shouldReceive('handle')->once();
            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);

            $formatter = \Mockery::mock(JsonFormatter::class);
            $formatter->shouldReceive('render')->once()->andReturn(ErrorResponse::fromException($e));
            $this->container->shouldReceive('make')->with(JsonFormatter::class)->once()->andReturn($formatter);

            $this->container->shouldReceive('make')->with(ResponseFactory::class)->once()->andReturn(
                $factory = \Mockery::mock(ResponseFactory::class)
            );

            $jsonResponse = new \Mosaic\Http\Adapters\Psr7\Response(new JsonResponse('Some message'));
            $factory->shouldReceive('make')->once()->andReturn($jsonResponse);

            $this->emitter->shouldReceive('emit')->with($jsonResponse)->once();

            $this->runner->handleException($e);
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
            $e = new ErrorException('Some message');

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

            $formatter->shouldReceive('render')->once()->andReturn(ErrorResponse::fromException($e));

            $this->container->shouldReceive('make')->with(LogHandler::class)->once()->andReturn($handler);
            $this->container->shouldReceive('make')->with(JsonFormatter::class)->once()->andReturn($formatter);

            $this->container->shouldReceive('make')->with(ResponseFactory::class)->once()->andReturn(
                $factory = \Mockery::mock(ResponseFactory::class)
            );

            $htmlResponse = new \Mosaic\Http\Adapters\Psr7\Response(new HtmlResponse('Some message'));
            $factory->shouldReceive('make')->once()->andReturn($htmlResponse);

            $this->emitter->shouldReceive('emit')->with($htmlResponse)->once();

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

namespace Mosaic\Exceptions {

    use Mosaic\Tests\Exceptions\RunnerTest;

    function error_get_last()
    {
        return RunnerTest::$error ?: \error_get_last();
    }
}
