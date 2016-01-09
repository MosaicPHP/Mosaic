<?php

namespace Fresco\Definitions;

use Fresco\Config\Adapters\LaravelConfig;
use Fresco\Contracts\Config\Config;
use Illuminate\Config\Repository;
use Interop\Container\Definition\DefinitionProviderInterface;

class LaravelConfigDefinition implements DefinitionProviderInterface
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
            Config::class => function () {
                return new LaravelConfig(
                    new Repository
                );
            }
        ];
    }
}
