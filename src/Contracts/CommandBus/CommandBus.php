<?php

namespace Fresco\Contracts\CommandBus;

use ArrayAccess;

interface CommandBus
{
    /**
     * @param  object $command
     * @param  array  $middleware
     * @return mixed
     */
    public function dispatch($command, array $middleware = []);

    /**
     * @param  string      $command
     * @param  ArrayAccess $input
     * @param  array       $extra
     * @param  array       $middleware
     * @return mixed
     */
    public function dispatchFrom($command, ArrayAccess $input, array $extra = [], array $middleware = []);

    /**
     * @param  string $command
     * @param  array  $input
     * @param  array  $middleware
     * @return mixed
     */
    public function dispatchFromArray($command, array $input = [], array $middleware = []);
}
