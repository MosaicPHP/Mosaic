<?php

namespace Fresco\Tests;

use Fresco\Application;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Http\Request;
use Fresco\Definitions\DiactorosDefinition;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\Registry;
use PHPUnit_Framework_TestCase;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function test_it_inits_a_registry_when_application_is_first_created()
    {
        $app = new Application(__DIR__);

        $this->assertInstanceOf(Registry::class, $app->getRegistry());
    }

    public function test_it_defines_a_default_container_when_application_is_first_created()
    {
        $app = new Application(__DIR__);

        $this->assertInstanceOf(Container::class, $app->getContainer());
    }

    public function test_can_set_a_custom_container_definition()
    {
        $app = new Application(__DIR__, ContainerDefinitionStub::class);

        $this->assertInstanceOf(Container::class, $app->getContainer());
        $this->assertInstanceOf(ContainerStub::class, $app->getContainer());
    }

    public function test_can_define_a_custom_container_definition()
    {
        $app = new Application(__DIR__);
        $app->defineContainer(ContainerDefinitionStub::class);

        $this->assertInstanceOf(Container::class, $app->getContainer());
        $this->assertInstanceOf(ContainerStub::class, $app->getContainer());
    }

    public function test_application_can_define_some_component()
    {
        $app = new Application(__DIR__);
        $app->define(new ContainerDefinitionStub);

        $this->assertInstanceOf(ContainerStub::class, $app->getRegistry()->getDefinitions()[Container::class]);
    }

    public function test_can_define_multiple_definitions_at_onces()
    {
        $app = new Application(__DIR__);
        $app->definitions([
            ContainerDefinitionStub::class
        ]);

        $this->assertInstanceOf(ContainerStub::class, $app->getRegistry()->getDefinitions()[Container::class]);
    }

    public function test_can_define_definition_groups()
    {
        $app = new Application(__DIR__);
        $app->definitions([
            DiactorosDefinition::class
        ]);

        $this->assertInstanceOf(\Fresco\Http\Adapters\Psr7\Request::class, $app->getRegistry()->getDefinitions()[Request::class]);
    }

    public function test_can_bootstrap_application()
    {
        $app = new Application(__DIR__);
        $app->bootstrap();

        // Register definitions is executed
        $this->assertInstanceOf(\Fresco\Container\Adapters\Laravel\Container::class, $app->getContainer()->make(Container::class));
    }

    public function tearDown()
    {
        parent::tearDown();
        Registry::flush();
    }
}

class ContainerDefinitionStub implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new ContainerStub();
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return Container::class;
    }
}

class ContainerStub implements Container
{
    /**
     * Resolve the given type from the container.
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        // TODO: Implement make() method.
    }

    /**
     * Call the given Closure / class@method and inject its dependencies.
     *
     * @param callable|string $callback
     * @param array           $parameters
     * @param string|null     $defaultMethod
     *
     * @return mixed
     */
    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        // TODO: Implement call() method.
    }

    /**
     * Register a binding with the container.
     *
     * @param string|array         $abstract
     * @param callable|string|null $concrete
     *
     * @return void
     */
    public function bind($abstract, $concrete = null)
    {
        // TODO: Implement bind() method.
    }

    /**
     * Register a shared binding in the container.
     *
     * @param string|array         $abstract
     * @param callable|string|null $concrete
     *
     * @return void
     */
    public function singleton($abstract, $concrete = null)
    {
        // TODO: Implement singleton() method.
    }

    /**
     * Determine if the given type has been bound.
     *
     * @param string $abstract
     *
     * @return bool
     */
    public function has($abstract)
    {
        // TODO: Implement has() method.
    }

    /**
     * Alias a type to a different name.
     *
     * @param string $abstract
     * @param string $alias
     *
     * @return void
     */
    public function alias($abstract, $alias)
    {
        // TODO: Implement alias() method.
    }

    /**
     * Register an existing instance as shared in the container.
     *
     * @param string $abstract
     * @param mixed  $instance
     */
    public function instance($abstract, $instance)
    {
        // TODO: Implement instance() method.
    }
}
