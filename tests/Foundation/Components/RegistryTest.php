<?php

namespace Fresco\Tests\Foundation\Components;

use Fresco\Contracts\Container\Container;
use Fresco\Definitions\LaravelContainerDefinition;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\Registry;
use LogicException;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public $registry;

    public function setUp()
    {
        $this->registry = new Registry();
    }

    public function test_can_define_a_definition()
    {
        $definition = new DefinitionStub();
        $this->registry->define(
            $definition
        );

        $this->assertEquals('concrete', $this->registry->getDefinitions()['abstract']);
    }

    public function test_can_get_container_when_container_is_defined()
    {
        $definition = new LaravelContainerDefinition();
        $this->registry->define(
            $definition
        );

        $this->assertInstanceOf(Container::class, $this->registry->getContainer());
    }

    public function test_cannot_get_container_when_container_is_not_defined()
    {
        $this->setExpectedException(LogicException::class, 'Container was not defined');

        $this->registry->getContainer();
    }

    public function tearDown()
    {
        parent::tearDown();
        Registry::flush();
    }
}

class DefinitionStub implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return 'concrete';
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return 'abstract';
    }
}
