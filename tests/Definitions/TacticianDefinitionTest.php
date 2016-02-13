<?php

namespace Fresco\Tests\Definitions;

use Fresco\Application;
use Fresco\Contracts\CommandBus\CommandBus;
use Fresco\Definitions\TacticianDefinition;
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
