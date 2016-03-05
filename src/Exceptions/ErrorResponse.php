<?php

namespace Mosaic\Exceptions;

use Throwable;

class ErrorResponse
{
    /**
     * @var mixed
     */
    private $output;

    /**
     * @var int
     */
    private $status;

    /**
     * ErrorResponse constructor.
     *
     * @param mixed $output
     * @param int   $status
     */
    public function __construct($output, int $status = 500)
    {
        $this->output = $output;
        $this->status = $status;
    }

    /**
     * @param Throwable $e
     * @param null      $message
     *
     * @return static
     */
    public static function fromException(Throwable $e, $message = null)
    {
        return new static(
            $message ?: $e->getMessage(),
            $e instanceof HttpException ? $e->getStatusCode() : 500
        );
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
