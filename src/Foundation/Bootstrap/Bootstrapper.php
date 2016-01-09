<?php

namespace Fresco\Foundation\Bootstrap;

use Fresco\Contracts\Application;

interface Bootstrapper
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app);
}
