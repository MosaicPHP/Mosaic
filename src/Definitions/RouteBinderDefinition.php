<?php

namespace Mosaic\Definitions;

use Mosaic\Contracts\Routing\RouteLoader;
use Mosaic\Routing\Loaders\LoadRoutesFromBinders;
use Interop\Container\Definition\DefinitionProviderInterface;

class RouteBinderDefinition implements DefinitionProviderInterface
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
            RouteLoader::class => LoadRoutesFromBinders::class
        ];
    }
}
