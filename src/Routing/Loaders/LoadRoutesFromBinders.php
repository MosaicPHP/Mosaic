<?php

namespace Fresco\Routing\Loaders;

use Fresco\Contracts\Application;
use Fresco\Contracts\Config\Config;
use Fresco\Contracts\Routing\RouteLoader;
use Fresco\Contracts\Routing\Router;

class LoadRoutesFromBinders implements RouteLoader
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var Config
     */
    private $config;

    /**
     * LoadRoutesFromBinders constructor.
     *
     * @param Application $app
     * @param Config      $config
     */
    public function __construct(Application $app, Config $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * @param Router $router
     *
     * @return mixed
     */
    public function loadRoutes(Router $router)
    {
        $binders = $this->config->get($this->app->getContext() . '.routes', []);
    }
}
