<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Application;
use Mosaic\Contracts\View\Factory;
use Mosaic\Definitions\TwigDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class TwigDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new TwigDefinition(new Application(__DIR__));
    }

    public function shouldDefine() : array
    {
        return [
            Factory::class
        ];
    }
}
