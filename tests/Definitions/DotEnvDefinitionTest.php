<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\EnvironmentVariablesLoader;
use Mosaic\Definitions\DotEnvDefinition;
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
