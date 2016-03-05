<?php

namespace Mosaic\Exceptions;

use Exception;
use Throwable;

class HttpException extends Exception
{
    /**
     * @var int
     */
    protected $status;

    /**
     * @param string         $message
     * @param int            $status
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $status = 500, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status;
    }
}
