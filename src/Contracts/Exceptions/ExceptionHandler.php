<?php

namespace Fresco\Contracts\Exceptions;

use Throwable;

interface ExceptionHandler
{
    /**
     * @param Throwable $e
     *
     * @return void
     */
    public function handle(Throwable $e);
}
