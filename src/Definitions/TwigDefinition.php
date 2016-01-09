<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Application;
use Fresco\Contracts\View\Factory as FactoryContract;
use Fresco\View\Adapters\Twig\Factory as TwigFactory;
use Interop\Container\Definition\DefinitionProviderInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigDefinition implements DefinitionProviderInterface
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
            FactoryContract::class => function ($container) {
                $app = $container->make(Application::class);

                return new TwigFactory(
                    new Twig_Environment(
                        new Twig_Loader_Filesystem($app->viewsPath()), [
                            'cache' => $app->storagePath('views')
                        ]
                    )
                );
            }
        ];
    }
}
