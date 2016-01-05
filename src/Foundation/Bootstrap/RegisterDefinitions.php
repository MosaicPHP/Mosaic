<?php

namespace Fresco\Foundation\Bootstrap;

use Fresco\Contracts\Application;

class RegisterDefinitions implements Bootstrapper
{
    /**
     * @var Application
     */
    private $app;

    /**
     * RegisterDefinitions constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Bootstrap
     * @return mixed
     */
    public function bootstrap()
    {
        foreach ($this->app->getRegistry()->getDefinitions() as $abstract => $concrete) {
            $this->app->getContainer()->instance($abstract, $concrete);
        }
    }
}
