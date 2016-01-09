<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\View\Factory;
use Fresco\Definitions\TwigDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class TwigDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new TwigDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            Factory::class
        ];
    }
}
