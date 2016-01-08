<?php

namespace Fresco\Tests\Definitions;

use Fresco\Tests\ClosesMockeryOnTearDown;

abstract class DefinitionGroupTestCase extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    public function test_can_define_definition_group()
    {
        $this->assertEquals($this->getDefinitions(), $this->getGroup()->getDefinitions());
    }

    abstract public function getDefinitions();

    abstract public function getGroup();
}
