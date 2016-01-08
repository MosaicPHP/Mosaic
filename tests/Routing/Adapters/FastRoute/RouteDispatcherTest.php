<?php

namespace Fresco\Tests\Routing\Adapters\FastRoute;

use Fresco\Contracts\Http\Request;
use Fresco\Exceptions\MethodNotAllowedException;
use Fresco\Exceptions\NotFoundHttpException;
use Fresco\Routing\Adapters\FastRoute\RouteDispatcher;
use Fresco\Routing\Route;
use Fresco\Routing\RouteCollection;
use Fresco\Tests\ClosesMockeryOnTearDown;

class RouteDispatcherTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var RouteDispatcher
     */
    private $dispatcher;

    public function setUp()
    {
        $this->dispatcher = new RouteDispatcher();
    }

    public function test_can_dispatch_an_existing_get_route()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('method')->once()->andReturn('GET');
        $request->shouldReceive('path')->once()->andReturn('/');

        $collection = new RouteCollection();
        $collection->add($givenRoute = new Route(['GET'], '/', 'HomeController@index'));

        $route = $this->dispatcher->dispatch($request, $collection);

        $this->assertEquals($givenRoute, $route);
    }

    public function test_can_dispatch_an_existing_post_route()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('method')->once()->andReturn('POST');
        $request->shouldReceive('path')->once()->andReturn('/');

        $collection = new RouteCollection();
        $collection->add($givenRoute = new Route(['POST'], '/', 'HomeController@index'));

        $route = $this->dispatcher->dispatch($request, $collection);

        $this->assertEquals($givenRoute, $route);
    }

    public function test_cannot_dispatch_post_route_as_get()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('method')->once()->andReturn('POST');
        $request->shouldReceive('path')->once()->andReturn('/');

        $collection = new RouteCollection();
        $collection->add($givenRoute = new Route(['GET'], '/', 'HomeController@index'));

        $this->setExpectedException(MethodNotAllowedException::class, 'Method [GET, HEAD] is not allowed');
        $this->dispatcher->dispatch($request, $collection);
    }

    public function test_cannot_dispatch_non_existing_route()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('method')->once()->andReturn('POST');
        $request->shouldReceive('path')->once()->andReturn('/');

        $this->setExpectedException(NotFoundHttpException::class);
        $this->dispatcher->dispatch($request, new RouteCollection());
    }
}
