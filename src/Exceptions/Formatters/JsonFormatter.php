<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
use Fresco\Exceptions\ErrorResponse;
use Fresco\Support\ArrayObject;
use Throwable;

class JsonFormatter implements ExceptionFormatter
{
    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    public function render(Throwable $e) : ErrorResponse
    {
        $output = new ArrayObject([
            'error' => [
                'message' => $e->getMessage()
            ]
        ]);

        return ErrorResponse::fromException($e, $output);
    }
}
