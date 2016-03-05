<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Application;
use Mosaic\Contracts\CommandBus\CommandBus;
use Mosaic\Definitions\TacticianDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class TacticianDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new TacticianDefinition(new Application(__DIR__));
    }

    public function shouldDefine() : array
    {
        return [
            CommandBus::class
        ];
    }
}
