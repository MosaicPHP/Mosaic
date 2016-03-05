<?php

namespace Mosaic\Foundation\Bootstrap;

use Mosaic\Contracts\Application;

interface Bootstrapper
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app);
}
