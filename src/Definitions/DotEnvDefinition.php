<?php

namespace Fresco\Definitions;

use Fresco\Contracts\EnvironmentVariablesLoader;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\EnvironmentVariables\Adapters\DotEnvVariableLoader;

class DotEnvDefinition implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new DotEnvVariableLoader();
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return EnvironmentVariablesLoader::class;
    }
}
