<?php

namespace Fresco\Tests\Http;

use Fresco\Contracts\Application;
use Fresco\Contracts\Http\Request;
use Fresco\Http\Adapters\Psr7\ResponseFactory;
use Fresco\Http\Stack;

class StackTest extends \PHPUnit_Framework_TestCase
{
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

    public function setUp()
    {
        $this->request = \Mockery::mock(Request::class);

        $this->stack = new Stack(
            $this->app = \Mockery::mock(Application::class)
        );
    }

    public function test_run_a_request_through_the_stack()
    {
        $this->app->shouldReceive('getContainer')->andReturn($this->app);
        $this->app->shouldReceive('make')->with(ReturnNext::class)->once()->andReturn(new ReturnNext);
        $this->app->shouldReceive('make')->with(ReturnSomeResponse::class)->once()->andReturn(new ReturnSomeResponse);

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
