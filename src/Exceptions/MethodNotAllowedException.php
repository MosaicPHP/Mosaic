<?php

namespace Fresco\Exceptions;

use Throwable;

class MethodNotAllowedException extends HttpException
{

    /**
     * @param string[]       $methods
     * @param int            $status
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($methods, $status = 500, $code = 0, Throwable $previous = null)
    {
        $message = 'Method ' . '[' . implode($methods, ', ') . '] is not allowed';
        parent::__construct($message, $status, $code, $previous);
    }
}
