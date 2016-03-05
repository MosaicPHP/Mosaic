<?php

namespace Mosaic\Definitions;

use Mosaic\Contracts\EnvironmentVariablesLoader;
use Mosaic\Foundation\EnvironmentVariables\Adapters\DotEnvVariableLoader;
use Interop\Container\Definition\DefinitionProviderInterface;

class DotEnvDefinition implements DefinitionProviderInterface
{
    /**
     * Returns the definition to register in the container.
     *
     * Definitions must be indexed by their entry ID. For example:
     *
     *     return [
     *         'logger' => ...
     *         'mailer' => ...
     *     ];
     *
     * @return array
     */
    public function getDefinitions()
    {
        return [
            EnvironmentVariablesLoader::class => function () {
                return new DotEnvVariableLoader();
            }
        ];
    }
}
