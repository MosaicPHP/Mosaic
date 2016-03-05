<?php

namespace Mosaic\Exceptions\Formatters;

use Mosaic\Contracts\Exceptions\ExceptionFormatter;
use Mosaic\Exceptions\ErrorResponse;
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
