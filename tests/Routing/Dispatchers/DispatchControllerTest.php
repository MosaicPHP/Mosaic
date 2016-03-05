<?php

namespace Mosaic\Tests\Routing\Dispatchers;

use Mosaic\Contracts\Container\Container;
use Mosaic\Exceptions\NotFoundHttpException;
use Mosaic\Routing\Dispatchers\DispatchController;
use Mosaic\Routing\MethodParameterResolver;
use Mosaic\Routing\Route;
use Mosaic\Tests\ClosesMockeryOnTearDown;

class DispatchControllerTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var Container|\Mockery\Mock
     */
    private $container;

    /**
     * @var MethodParameterResolver|\Mockery\Mock
     */
    private $resolver;

    /**
     * @var DispatchController
     */
    private $dispatcher;

    public function setUp()
    {
        $this->container = \Mockery::mock(Container::class);
        $this->resolver  = \Mockery::mock(MethodParameterResolver::class);
        $this->resolver->shouldReceive('resolve')->andReturn([]);

        $this->dispatcher = new DispatchController(
            $this->container,
            $this->resolver
        );
    }

    public function test_can_dispatch_controller()
    {
        $controller = new ControllerStub;
        $this->container->shouldReceive('make')->with('Mosaic\Tests\Routing\Dispatchers\ControllerStub')->once()->andReturn($controller);
        $this->container->shouldReceive('call')->with([$controller, 'index'], [])->once()->andReturn($controller->index());

        $route = new Route(['GET'], '/', ['uses' => 'Mosaic\Tests\Routing\Dispatchers\ControllerStub@index']);

        $response = $this->dispatcher->dispatch($route);

        $this->assertEquals('response', $response);
    }

    public function test_cannot_dispatch_when_controller_does_not_exist()
    {
        $this->setExpectedException(\ReflectionException::class);

        $this->container->shouldReceive('make')->with('ControllerNotExists')->once()->andThrow(\ReflectionException::class);

        $route = new Route(['GET'], '/', ['uses' => 'ControllerNotExists@index']);

        $response = $this->dispatcher->dispatch($route);
    }

    public function test_cannot_dispatch_when_method_does_not_exist()
    {
        $this->setExpectedException(NotFoundHttpException::class);

        $controller = new ControllerStub;
        $this->container->shouldReceive('make')->with('Mosaic\Tests\Routing\Dispatchers\ControllerStub')->once()->andReturn($controller);

        $route = new Route(['GET'], '/', ['uses' => 'Mosaic\Tests\Routing\Dispatchers\ControllerStub@nonExisting']);

        $this->dispatcher->dispatch($route);
    }
}

class ControllerStub
{
    public function index()
    {
        return 'response';
    }
}
