<?php

namespace Fresco\Tests\Exceptions;

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
}

class AppExceptionRunner extends Runner
{
    /**
     * @var array
     */
    protected $shouldNotHandle = [
        \InvalidArgumentException::class
    ];
}
