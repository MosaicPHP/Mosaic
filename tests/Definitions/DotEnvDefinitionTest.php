<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\EnvironmentVariablesLoader;
use Fresco\Definitions\DotEnvDefinition;
use Fresco\Foundation\EnvironmentVariables\Adapters\DotEnvVariableLoader;

class DotEnvDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new DotEnvDefinition();
    }

    public function getAs()
    {
        return EnvironmentVariablesLoader::class;
    }

    public function getAdapter()
    {
        return DotEnvVariableLoader::class;
    }
}
