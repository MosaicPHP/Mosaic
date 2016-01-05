<?php

namespace Fresco\Tests\Definitions;

abstract class DefinitionGroupTestCase extends \PHPUnit_Framework_TestCase
{
    public function test_can_define_definition_group()
    {
        $this->assertEquals($this->getDefinitions(), $this->getGroup()->getDefinitions());
    }

    abstract public function getDefinitions();

    abstract public function getGroup();
}
