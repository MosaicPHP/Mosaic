<?php

namespace Mosaic\Tests\CommandBus;

use Mosaic\CommandBus\Marshal;
use Mosaic\Support\ArrayObject;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class MarshalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Marshal
     */
    protected $marshal;

    public function setUp()
    {
        $this->marshal = new Marshal;
    }

    public function test_can_get_instance_without_additional_parameters()
    {
        $instance = $this->marshal->getClassInstance(NoConstructorParamsCommand::class, new ArrayObject, []);

        $this->assertInstanceOf(NoConstructorParamsCommand::class, $instance);
    }

    public function test_can_get_instance_with_additional_parameters_through_an_array_object()
    {
        $instance = $this->marshal->getClassInstance(ConstructorParamsCommand::class,
            new ArrayObject(['id' => 1, 'name' => 'Name']), []);

        $this->assertInstanceOf(ConstructorParamsCommand::class, $instance);
        $this->assertEquals(1, $instance->id);
        $this->assertEquals('Name', $instance->name);
    }

    public function test_can_get_instance_with_additional_parameters_through_an_array_object_with_extra_array()
    {
        $instance = $this->marshal->getClassInstance(
            ConstructorParamsCommand::class,
            new ArrayObject(['id' => 1]), ['name' => 'Name']
        );

        $this->assertInstanceOf(ConstructorParamsCommand::class, $instance);
        $this->assertEquals(1, $instance->id);
        $this->assertEquals('Name', $instance->name);
    }

    public function test_can_get_instance_with_default_param_values()
    {
        $instance = $this->marshal->getClassInstance(
            ConstructorParamsWithDefaultCommand::class,
            new ArrayObject()
        );

        $this->assertInstanceOf(ConstructorParamsWithDefaultCommand::class, $instance);
        $this->assertEquals('some_id', $instance->id);
    }

    public function test_throws_exception_when_cant_map_input_to_the_command()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Unable to map input to command: id');
        $this->marshal->getClassInstance(ConstructorParamsCommand::class, new ArrayObject);
    }
}

class NoConstructorParamsCommand
{
}

class ConstructorParamsCommand
{
    public $id;
    public $name;

    public function __construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }
}

class ConstructorParamsWithDefaultCommand
{
    public $id;

    public function __construct($id = 'some_id')
    {
        $this->id = $id;
    }
}
