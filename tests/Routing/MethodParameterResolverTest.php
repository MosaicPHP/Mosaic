<?php

namespace Fresco\Tests\Routing;

use Fresco\Contracts\Container\Container;
use Fresco\Routing\MethodParameterResolver;
use Fresco\Tests\ClosesMockeryOnTearDown;

class MethodParameterResolverTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var \Mockery\Mock|Container
     */
    private $container;

    /**
     * @var MethodParameterResolver
     */
    private $resolver;

    public function setUp()
    {
        $this->container = \Mockery::mock(Container::class);
        $this->resolver  = new MethodParameterResolver($this->container);
    }

    public function test_can_resolve_closure_parameters_with_typehints_without_route_parameters()
    {
        $this->container->shouldReceive('make')->with(Container::class)->once()->andReturn($this->container);

        $closure = function (Container $container) {
        };

        $parameters = $this->resolver->resolve(
            new \ReflectionFunction($closure),
            []
        );

        $this->assertArrayHasKey('container', $parameters);
        $this->assertEquals($this->container, $parameters['container']);
    }

    public function test_can_resolve_closure_parameters_with_typehints_and_route_parameters()
    {
        $this->container->shouldReceive('make')->with(Container::class)->once()->andReturn($this->container);

        $closure = function (Container $container, $id) {
        };

        $parameters = $this->resolver->resolve(
            new \ReflectionFunction($closure),
            [
                'id' => 1
            ]
        );

        $this->assertArrayHasKey('container', $parameters);
        $this->assertArrayHasKey('id', $parameters);
        $this->assertEquals($this->container, $parameters['container']);
        $this->assertEquals(1, $parameters['id']);
    }

    public function test_can_resolve_method_parameters_with_typehints_without_route_parameters()
    {
        $this->container->shouldReceive('make')->with(Container::class)->once()->andReturn($this->container);

        $parameters = $this->resolver->resolve(
            new \ReflectionMethod(ControllerStubWithoutParams::class, 'index'),
            []
        );

        $this->assertArrayHasKey('container', $parameters);
        $this->assertEquals($this->container, $parameters['container']);
    }

    public function test_can_resolve_method_parameters_with_typehints_and_route_parameters()
    {
        $this->container->shouldReceive('make')->with(Container::class)->once()->andReturn($this->container);

        $parameters = $this->resolver->resolve(
            new \ReflectionMethod(ControllerStubWithParams::class, 'index'),
            [
                'id' => 1
            ]
        );

        $this->assertArrayHasKey('container', $parameters);
        $this->assertArrayHasKey('id', $parameters);
        $this->assertEquals($this->container, $parameters['container']);
        $this->assertEquals(1, $parameters['id']);
    }
}

class ControllerStubWithoutParams
{
    public function index(Container $container)
    {
    }
}

class ControllerStubWithParams
{
    public function index(Container $container, $id)
    {
    }
}
