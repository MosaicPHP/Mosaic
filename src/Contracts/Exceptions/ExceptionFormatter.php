<?php

namespace Fresco\Contracts\Exceptions;

use Throwable;

interface ExceptionFormatter
{
    /**
     * @param Throwable $e
     */
    public function render(Throwable $e);
}
