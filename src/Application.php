<?php

namespace Fresco;

use Fresco\Contracts\Application as ApplicationContract;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Container\ContainerDefinition;
use Fresco\Contracts\Exceptions\ExceptionRunner;
use Fresco\Contracts\Http\Server;
use Fresco\Definitions\LaravelContainerDefinition;
use Fresco\Foundation\Bootstrap\HandleExceptions;
use Fresco\Foundation\Bootstrap\LoadConfiguration;
use Fresco\Foundation\Bootstrap\LoadEnvironmentVariables;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Registry;
use Interop\Container\Definition\DefinitionProviderInterface;

class Application implements ApplicationContract
{
    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Server
     */
    protected $context;

    /**
     * @var null
     */
    protected $path;

    /**
     * @var string
     */
    protected $env = 'production';

    /**
     * @var array
     */
    protected $bootstrappers = [
        RegisterDefinitions::class,
        LoadEnvironmentVariables::class,
        LoadConfiguration::class,
        HandleExceptions::class
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

        $this->defineContainer(new $containerDefinition);
    }

    /**
     * Application root path
     *
     * @param string $path
     *
     * @return string
     */
    public function path(string $path = '') : string
    {
        return rtrim($this->path . '/' . $path, '/');
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function configPath(string $path = '') : string
    {
        return $this->path('config/' . $path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function storagePath(string $path = '') : string
    {
        return $this->path('storage/' . $path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function viewsPath(string $path = '') : string
    {
        return $this->path('resources/views/' . $path);
    }

    /**
     * @param DefinitionProviderInterface $definition
     */
    public function define(DefinitionProviderInterface $definition)
    {
        $this->getRegistry()->define($definition, $this);
    }

    /**
     * @param string[] $definitions
     */
    public function definitions(array $definitions)
    {
        foreach ($definitions as $definition) {
            $this->define(
                new $definition($this)
            );
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
     * @param ContainerDefinition $definition
     *
     * @return Container
     */
    public function defineContainer(ContainerDefinition $definition) : Container
    {
        $this->container = $definition->getDefinition();
        $this->container->instance(Container::class, $this->container);
        $this->container->instance(ApplicationContract::class, $this);

        return $this->container;
    }

    /**
     * Bootstrap the Application
     */
    public function bootstrap()
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            $this->getContainer()->make($bootstrapper)->bootstrap($this);
        }
    }

    /**
     * @return string
     */
    public function env() : string
    {
        return $this->env;
    }

    /**
     * @param string $env
     */
    public function setEnvironment(string $env)
    {
        $this->env = $env;
    }

    /**
     * @return bool
     */
    public function isLocal() : bool
    {
        return $this->env() === 'local';
    }

    /**
     * @param ExceptionRunner $runner
     */
    public function setExceptionRunner(ExceptionRunner $runner)
    {
        $this->getContainer()->bind(ExceptionRunner::class, function () use ($runner) {
            return $runner;
        });
    }

    /**
     * @return ExceptionRunner
     */
    public function getExceptionRunner() : ExceptionRunner
    {
        return $this->getContainer()->make(ExceptionRunner::class);
    }

    /**
     * @param string $context
     */
    public function setContext(string $context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getContext() : string
    {
        return $this->context;
    }
}
