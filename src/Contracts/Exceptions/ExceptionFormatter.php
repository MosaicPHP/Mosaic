<?php

namespace Mosaic\Contracts\Exceptions;

use Mosaic\Exceptions\ErrorResponse;
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
