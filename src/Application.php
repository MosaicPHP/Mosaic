<?php

namespace Fresco;

use Fresco\Contracts\Application as ApplicationContract;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Http\Request;
use Fresco\Definitions\LaravelContainerDefinition;
use Fresco\Foundation\Bootstrap\HandleExceptions;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\Registry;

class Application implements ApplicationContract
{

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var null
     */
    private $path;

    /**
     * @var array
     */
    private $bootstrappers = [
        HandleExceptions::class,
        RegisterDefinitions::class,
    ];

    /**
     * Application constructor.
     *
     * @param string $path
     * @param string $containerDefinition
     */
    public function __construct(string $path, string $containerDefinition = LaravelContainerDefinition::class)
    {
        $this->path = $path;
        $this->registry = new Registry();

        $this->defineContainer($containerDefinition);
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
    public function getRegistry() : Registry
    {
        return $this->registry;
    }

    /**
     * @return Container
     */
    public function getContainer() : Container
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
    public function defineContainer(string $definition) : Container
    {
        $this->definitions([
            $definition
        ]);

        $this->container = $this->registry->getContainer();

        $this->container->instance('app', $this);
        $this->container->instance(ApplicationContract::class, $this);

        return $this->container;
    }

    /**
     * Bootstrap the Application
     */
    public function bootstrap()
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper($this))->bootstrap();
        }
    }
}
