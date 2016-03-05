<?php

namespace Mosaic\Foundation\Bootstrap;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Exceptions\ExceptionRunner;

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
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        error_reporting(-1);

        ini_set('display_errors', 'Off');

        set_error_handler([$this->handler, 'handleError']);

        set_exception_handler([$this->handler, 'handleException']);

        register_shutdown_function([$this->handler, 'handleShutdown']);
    }
}
