<?php

namespace Fresco\Tests\Container\Adapters\Laravel;

use Fresco\Container\Adapters\Laravel\Container as Adapter;
use Fresco\Contracts\Container\Container as ContainerContract;
use Illuminate\Container\Container;

class LaravelContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerContract
     */
    private $container;

    /**
     * @var Container|\Mockery\MockInterface
     */
    private $wrappedMock;

    protected function setUp()
    {
        $this->container = new Adapter(
            $this->wrappedMock = \Mockery::mock(Container::class)
        );
    }

    public function test_it_implements_the_fresco_container_interface()
    {
        $this->assertInstanceOf(ContainerContract::class, $this->container);
    }

    public function test_it_can_resolve_a_given_type_from_the_container()
    {
        $abstract   = 'abstract';
        $parameters = ['foo' => 'bar'];

        $this->wrappedMock->shouldReceive('make')->with($abstract, $parameters)->once()->andReturn('resolved');

        $this->assertEquals('resolved', $this->container->make($abstract, $parameters));
    }

    public function test_it_call_call_a_callable()
    {
        $callback = function () {};
        $parameters    = ['foo' => 'bar'];
        $defaultMethod = null;

        $this->wrappedMock->shouldReceive('call')->with($callback, $parameters, $defaultMethod)->once()->andReturn('resolved');

        $this->assertEquals('resolved', $this->container->call($callback, $parameters, $defaultMethod));
    }

    public function test_can_register_a_binding_in_the_container()
    {
        $abstract = 'abstract';
        $concrete = 'concrete';

        $this->wrappedMock->shouldReceive('bind')->with($abstract, $concrete)->once()->andReturn('resolved');

        $this->container->bind($abstract, $concrete);
    }

    public function test_can_register_a_singleton_in_the_container()
    {
        $abstract = 'abstract';
        $concrete = 'concrete';

        $this->wrappedMock->shouldReceive('singleton')->with($abstract, $concrete)->once()->andReturn('resolved');

        $this->container->singleton($abstract, $concrete);
    }

    public function test_can_register_an_alias_in_the_container()
    {
        $abstract = 'abstract';
        $concrete = 'concrete';

        $this->wrappedMock->shouldReceive('alias')->with($abstract, $concrete)->once()->andReturn('resolved');

        $this->container->alias($abstract, $concrete);
    }

    public function test_can_register_an_instance_in_the_container()
    {
        $abstract = 'abstract';
        $concrete = 'concrete';

        $this->wrappedMock->shouldReceive('instance')->with($abstract, $concrete)->once()->andReturn('resolved');

        $this->container->instance($abstract, $concrete);
    }

    public function test_can_check_if_a_binding_exists()
    {
        $abstract = 'abstract';

        $this->wrappedMock->shouldReceive('bound')->with($abstract)->once()->andReturn(true);

        $this->assertTrue($this->container->has($abstract));
    }
}
