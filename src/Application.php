<?php

namespace Fresco;

use Fresco\Contracts\Application as ApplicationContract;
use Fresco\Contracts\Container\Container;
use Fresco\Definitions\LaravelContainerDefinition;
use Fresco\Foundation\Bootstrap\HandleExceptions;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\DefinitionGroup;
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
        RegisterDefinitions::class,
        HandleExceptions::class,
    ];

    /**
     * Application constructor.
     *
     * @param string $path
     * @param string $containerDefinition
     */
    public function __construct(string $path, string $containerDefinition = LaravelContainerDefinition::class)
    {
        $this->path     = $path;
        $this->registry = new Registry();

        $this->defineContainer($containerDefinition);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function storagePath($path = '') : string
    {
        return rtrim($this->path . '/storage/' . $path, '/');
    }

    /**
     * @return string
     */
    public function viewsPath() : string
    {
        return $this->path . '/resources/views';
    }

    /**
     * @param Definition $definition
     */
    public function define(Definition $definition)
    {
        $this->getRegistry()->define($definition, $this);
    }

    /**
     * @param string[] $definitions
     */
    public function definitions(array $definitions)
    {
        foreach ($definitions as $definition) {
            $definition = new $definition($this);

            if ($definition instanceof DefinitionGroup) {
                $this->definitions($definition->getDefinitions());
            } else {
                $this->define($definition);
            }
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
     * @throws \Exception
     * @return Container
     */
    public function defineContainer(string $definition) : Container
    {
        $this->definitions([
            $definition
        ]);

        $this->container = $this->registry->getContainer();

        $this->container->instance(ApplicationContract::class, $this);

        return $this->container;
    }

    /**
     * Bootstrap the Application
     */
    public function bootstrap()
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            $this->getContainer()->make($bootstrapper)->bootstrap();
        }
    }

    public function isLocal()
    {
        return true;
    }
}
