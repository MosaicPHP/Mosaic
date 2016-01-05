<?php

namespace Fresco\Tests\Definitions;

abstract class DefinitionTestCase extends \PHPUnit_Framework_TestCase
{
    public function test_can_define_definition()
    {
        $this->assertInstanceOf($this->getAdapter(), $this->getDefinition()->define());
        $this->assertEquals($this->getAs(), $this->getDefinition()->defineAs());
    }

    abstract public function getDefinition();

    abstract public function getAs();

    abstract public function getAdapter();
}
