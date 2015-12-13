<?php

namespace Fresco;

use Fresco\Contracts\Application as ApplicationContract;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Http\Request;
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
     * @param null $path
     */
    public function __construct($path = null)
    {
        $this->path = $path;
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
        return $this->registry = $this->registry ?: new Registry();
    }

    // Temporary
    public function bootstrap()
    {
        $this->container = $this->registry->getContainer();

        foreach ($this->registry->getDefinitions() as $abstract => $concrete) {
            $this->container->instance($abstract, $concrete);
        }

        $this->container->instance('app', $this);
        $this->container->instance(ApplicationContract::class, $this);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
