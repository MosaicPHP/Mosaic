<?php

namespace Mosaic\CommandBus;

use ArrayAccess;
use Mosaic\Contracts\CommandBus\CommandBus;
use Mosaic\Contracts\Container\Container;

abstract class AbstractBus implements CommandBus
{
    /**
     * @param              $command
     * @param  ArrayAccess $input
     * @param  array       $extra
     * @return object
     */
    protected function marshal($command, ArrayAccess $input, array $extra = [])
    {
        return (new Marshal)->getClassInstance($command, $input, $extra);
    }

    /**
     * Resolve the middleware stack from the laravel container
     * @param  array     $middleware
     * @param  Container $container
     * @return array
     */
    protected function resolveMiddleware(array $middleware = [], Container $container)
    {
        $m = [];
        foreach ($middleware as $class) {
            $m[] = $container->make($class);
        }

        return $m;
    }
}
