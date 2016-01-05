<?php

namespace Fresco\Exceptions;

use Throwable;

class NotFoundHttpException extends HttpException
{
    /**
     * @param string         $message
     * @param int            $status
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Not found", $status = 404, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $status, $code, $previous);
    }
}
