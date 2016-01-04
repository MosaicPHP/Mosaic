<?php

namespace Fresco;

use Fresco\Contracts\Application as ApplicationContract;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Http\Request;
use Fresco\Definitions\LaravelContainerDefinition;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\Registry;

class Application implements ApplicationContract
{

    /**
     * @var null
     */
    private $path;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var Container
     */
    private $container;

    /**
     * Application constructor.
     *
     * @param null   $path
     * @param string $containerDefinition
     */
    public function __construct($path = null, $containerDefinition = LaravelContainerDefinition::class)
    {
        $this->path = $path;
        $this->registry = new Registry();

        $this->defineContainer($containerDefinition);
    }

    /**
     * @return Request
     */
    public function captureRequest()
    {
        return $this->getContainer()->make(Request::class);
    }

    /**
     * @param Definition $definition
     */
    public function define(Definition $definition)
    {
        $this->getRegistry()->define($definition);
    }

    /**
     * @param string[] $definitions
     */
    public function definitions(array $definitions)
    {
        foreach ($definitions as $definition) {
            $this->define(new $definition);
        }
    }

    /**
     * @return Registry
     */
    public function getRegistry()
    {
        return $this->registry;
    }

    /**
     * Bootstrap the app
     */
    public function bootstrap()
    {
        foreach ($this->registry->getDefinitions() as $abstract => $concrete) {
            $this->container->instance($abstract, $concrete);
        }
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Define a container implementation
     *
     * @param string $definition
     *
     * @return Container
     * @throws \Exception
     */
    public function defineContainer($definition)
    {
        $this->definitions([
            $definition
        ]);

        $this->container = $this->registry->getContainer();

        $this->container->instance('app', $this);
        $this->container->instance(ApplicationContract::class, $this);

        return $this->container;
    }
}
