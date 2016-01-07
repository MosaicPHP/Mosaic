<?php

namespace Fresco\Tests\Http\Middleware;

use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\Response;
use Fresco\Contracts\Http\ResponseFactory;
use Fresco\Contracts\Routing\RouteDispatcher;
use Fresco\Contracts\Routing\Router;
use Fresco\Http\Middleware\DispatchRequest;
use Fresco\Routing\Dispatchers\DispatchClosure;
use Fresco\Routing\Dispatchers\DispatchController;
use Fresco\Routing\Route;
use Fresco\Routing\RouteCollection;
use Mockery\Mock;
use PHPUnit_Framework_TestCase;

class DispatchRequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DispatchRequest
     */
    private $middleware;

    /**
     * @var Mock
     */
    private $response;

    /**
     * @var Mock
     */
    private $dispatcher;

    /**
     * @var Mock
     */
    private $router;

    /**
     * @var Mock
     */
    private $controller;

    /**
     * @var Mock
     */
    private $closure;

    /**
     * @var Mock
     */
    private $factory;

    /**
     * @var Mock
     */
    private $request;

    public function setUp()
    {
        $this->dispatcher = \Mockery::mock(RouteDispatcher::class);
        $this->router     = \Mockery::mock(Router::class);
        $this->controller = \Mockery::mock(DispatchController::class);
        $this->closure    = \Mockery::mock(DispatchClosure::class);
        $this->factory    = \Mockery::mock(ResponseFactory::class);
        $this->request    = \Mockery::mock(Request::class);
        $this->response   = \Mockery::mock(Response::class);

        $this->middleware = new DispatchRequest(
            $this->dispatcher,
            $this->router,
            $this->controller,
            $this->closure,
            $this->factory
        );
    }

    public function test_can_dispatch_request_as_closure()
    {
        $middleware = $this->middleware;

        $routes = new RouteCollection();
        $route  = new Route(['GET'], '/', function () {
        });

        $this->router->shouldReceive('all')->andReturn($routes);
        $this->dispatcher->shouldReceive('dispatch')->with($this->request, $routes)->andReturn($route);

        $this->closure->shouldReceive('isSatisfiedBy')->with($route)->andReturn(true);
        $this->closure->shouldReceive('dispatch')->with($route)->andReturn('response');
        $this->factory->shouldReceive('make')->with('response')->andReturn($this->response);

        $this->assertEquals($this->response, $middleware($this->request));
    }

    public function test_can_dispatch_request_as_controller()
    {
        $middleware = $this->middleware;

        $routes = new RouteCollection();
        $route  = new Route(['GET'], '/', 'HomeController@index');

        $this->router->shouldReceive('all')->andReturn($routes);
        $this->dispatcher->shouldReceive('dispatch')->with($this->request, $routes)->andReturn($route);

        $this->closure->shouldReceive('isSatisfiedBy')->with($route)->andReturn(false);
        $this->controller->shouldReceive('dispatch')->with($route)->andReturn('response');
        $this->factory->shouldReceive('make')->with('response')->andReturn($this->response);

        $this->assertEquals($this->response, $middleware($this->request));
    }
}
