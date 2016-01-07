<?php

namespace Fresco\Tests\Definitions;

use Fresco\Application;
use Fresco\Definitions\TwigDefinition;
use Fresco\View\Adapters\Twig\Factory;

class TwigDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new TwigDefinition(
            new Application(__DIR__ . '/../fixtures')
        );
    }

    public function getAs()
    {
        return \Fresco\Contracts\View\Factory::class;
    }

    public function getAdapter()
    {
        return Factory::class;
    }
}
