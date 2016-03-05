<?php

namespace Mosaic\Exceptions\Formatters;

use Mosaic\Contracts\Exceptions\ExceptionFormatter;
use Mosaic\Exceptions\ErrorResponse;
use Mosaic\Support\ArrayObject;
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
