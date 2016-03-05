<?php

namespace Mosaic\Definitions;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\View\Factory as FactoryContract;
use Mosaic\View\Adapters\Twig\Factory as TwigFactory;
use Illuminate\Contracts\Container\Container;
use Interop\Container\Definition\DefinitionProviderInterface;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigDefinition implements DefinitionProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * TwigDefinition constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

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
            FactoryContract::class => function () {
                return new TwigFactory(
                    new Twig_Environment(
                        new Twig_Loader_Filesystem($this->app->viewsPath()), [
                            'cache' => $this->app->storagePath('views')
                        ]
                    )
                );
            }
        ];
    }
}
