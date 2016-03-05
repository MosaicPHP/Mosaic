<?php

namespace Mosaic\Foundation\Bootstrap;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\EnvironmentVariablesLoader;

class LoadEnvironmentVariables implements Bootstrapper
{
    /**
     * @var EnvironmentVariablesLoader
     */
    private $loader;

    /**
     * LoadEnvironmentVariables constructor.
     *
     * @param EnvironmentVariablesLoader $loader
     */
    public function __construct(EnvironmentVariablesLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $this->loader->load(
            $app->path()
        );
    }
}
