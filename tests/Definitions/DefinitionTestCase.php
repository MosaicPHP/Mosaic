<?php

namespace Fresco\Tests\Definitions;

use Interop\Container\Definition\DefinitionProviderInterface;

abstract class DefinitionTestCase extends \PHPUnit_Framework_TestCase
{
    abstract public function getDefinition() : DefinitionProviderInterface;

    abstract public function shouldDefine() : array;

    public function test_defines_all_required_contracts()
    {
        $definitions = $this->getDefinition()->getDefinitions();
        foreach ($this->shouldDefine() as $define) {
            $this->assertArrayHasKey($define, $definitions);
        }
    }
}
