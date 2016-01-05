<?php

namespace Fresco\Contracts\Exceptions;

use Throwable;

interface ExceptionHandler
{
    /**
     * @param Throwable $e
     */
    public function handle(Throwable $e);
}
