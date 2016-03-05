<?php

namespace Mosaic\Tests\Http;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Container\Container;
use Mosaic\Contracts\Http\Request;
use Mosaic\Http\Adapters\Psr7\ResponseFactory;
use Mosaic\Http\Stack;
use Mosaic\Tests\ClosesMockeryOnTearDown;
use Mockery\Mock;

class StackTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var Stack
     */
    public $stack;

    /**
     * @var Application|\Mockery\Mock
     */
    public $app;

    /**
     * @var Request|\Mockery\Mock
     */
    public $request;

    /**
     * @var Mock
     */
    public $container;

    public function setUp()
    {
        $this->request = \Mockery::mock(Request::class);

        $this->container = \Mockery::mock(Container::class);

        $this->stack = new Stack(
            $this->app = \Mockery::mock(Application::class)
        );
    }

    public function test_run_a_request_through_the_stack()
    {
        $this->app->shouldReceive('getContainer')->andReturn($this->container);
        $this->container->shouldReceive('make')->with(ReturnNext::class)->once()->andReturn(new ReturnNext);
        $this->container->shouldReceive('make')->with(ReturnSomeResponse::class)->once()->andReturn(new ReturnSomeResponse);

        $response = $this->stack->run($this->request)->through([
            ReturnNext::class,
            ReturnSomeResponse::class
        ]);

        $this->assertEquals('Html body', $response->body());
    }
}

class ReturnSomeResponse
{
    public function __invoke(Request $request, callable $next)
    {
        return (new ResponseFactory)->html('Html body');
    }
}

class ReturnNext
{
    public function __invoke(Request $request, callable $next)
    {
        return $next($request);
    }
}
