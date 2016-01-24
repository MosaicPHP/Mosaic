<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
use Fresco\Exceptions\ErrorResponse;
use Throwable;

class ConsoleFormatter implements ExceptionFormatter
{
    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    public function render(Throwable $e) : ErrorResponse
    {
        return ErrorResponse::fromException($e);
    }
}
