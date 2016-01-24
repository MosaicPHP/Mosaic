<?php

namespace Fresco\Contracts\Exceptions;

use Fresco\Exceptions\ErrorResponse;
use Throwable;

interface ExceptionFormatter
{
    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    public function render(Throwable $e) : ErrorResponse;
}
