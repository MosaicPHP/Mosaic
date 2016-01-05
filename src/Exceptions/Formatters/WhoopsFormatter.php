<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
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
     * WhoopsFormatter constructor.
     */
    public function __construct()
    {
        $this->whoops = new Run();
        $this->whoops->pushHandler(new PrettyPageHandler);
    }

    /**
     * @param Throwable $e
     */
    public function render(Throwable $e)
    {
        $this->whoops->handleException($e);
    }
}
