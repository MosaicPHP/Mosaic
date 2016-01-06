<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
use Fresco\Exceptions\HttpException;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsFormatter implements ExceptionFormatter
{
    /**
     * @var Run
     */
    private $whoops;

    /**
     * @param Run $whoops
     */
    public function __construct(Run $whoops)
    {
        $this->whoops = $whoops;
        $this->whoops->pushHandler(new PrettyPageHandler);
    }

    /**
     * @param Throwable $e
     */
    public function render(Throwable $e)
    {
        $this->whoops->sendHttpCode(
            $e instanceof HttpException ? $e->getStatusCode() : 500
        );

        $this->whoops->handleException($e);
    }
}
