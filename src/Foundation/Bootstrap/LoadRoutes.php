<?php

namespace Mosaic\Foundation\Bootstrap;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Routing\RouteLoader;
use Mosaic\Contracts\Routing\Router;

class LoadRoutes implements Bootstrapper
{
    /**
     * @var RouteLoader
     */
    private $loader;

    /**
     * @var Router
     */
    private $router;

    /**
     * LoadRoutes constructor.
     *
     * @param RouteLoader $loader
     * @param Router      $router
     */
    public function __construct(RouteLoader $loader, Router $router)
    {
        $this->loader = $loader;
        $this->router = $router;
    }

    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $this->loader->loadRoutes($this->router);
    }
}
