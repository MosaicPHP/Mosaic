<?php

namespace Fresco\Foundation\Bootstrap;

use Fresco\Contracts\Application;
use Fresco\Contracts\Container\Container;

class RegisterDefinitions implements Bootstrapper
{
    /**
     * @var Container
     */
    private $container;

    /**
     * RegisterDefinitions constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        foreach ($app->getRegistry()->getDefinitions() as $abstract => $concrete) {
            if (is_string($concrete) || is_callable($concrete)) {
                $this->container->bind($abstract, $concrete);
            } else {
                $this->container->instance($abstract, $concrete);
            }
        }
    }
}
