<?php

namespace Fresco\Foundation\Bootstrap;

use Fresco\Contracts\Exceptions\ExceptionRunner;

class HandleExceptions implements Bootstrapper
{
    /**
     * @var ExceptionRunner
     */
    private $handler;

    /**
     * RegisterDefinitions constructor.
     *
     * @param ExceptionRunner $handler
     */
    public function __construct(ExceptionRunner $handler)
    {
        $this->handler = $handler;
    }

    /**
     * Bootstrap
     * @return mixed
     */
    public function bootstrap()
    {
        error_reporting(-1);

        ini_set('display_errors', 'Off');

        set_error_handler([$this->handler, 'handleError']);

        set_exception_handler([$this->handler, 'handleException']);

        register_shutdown_function([$this->handler, 'handleShutdown']);
    }
}
