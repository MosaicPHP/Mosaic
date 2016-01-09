<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\EnvironmentVariablesLoader;
use Fresco\Definitions\DotEnvDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class DotEnvDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new DotEnvDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            EnvironmentVariablesLoader::class,
        ];
    }
}
