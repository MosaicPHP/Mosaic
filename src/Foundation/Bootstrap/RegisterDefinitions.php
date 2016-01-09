<?php

namespace Fresco\Foundation\Bootstrap;

use Fresco\Contracts\Application;

class RegisterDefinitions implements Bootstrapper
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        foreach ($app->getRegistry()->getDefinitions() as $abstract => $concrete) {
            $app->getContainer()->instance($abstract, $concrete);
        }
    }
}
