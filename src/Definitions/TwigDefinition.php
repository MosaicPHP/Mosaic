<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Application;
use Fresco\Contracts\View\Factory;
use Fresco\Foundation\Components\Definition;
use Fresco\View\Adapters\Twig\Factory as TwigFactory;
use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigDefinition implements Definition
{
    /**
     * @var Application
     */
    private $app;

    /**
     * TwigDefinition constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return mixed
     */
    public function define()
    {
        return new TwigFactory(
            new Twig_Environment(
                new Twig_Loader_Filesystem($this->app->viewsPath()), [
                    'cache' => $this->app->storagePath('views')
                ]
            )
        );
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return Factory::class;
    }
}
