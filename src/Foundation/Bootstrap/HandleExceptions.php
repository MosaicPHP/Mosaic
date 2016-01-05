<?php

namespace Fresco\Foundation\Bootstrap;

use ErrorException;
use Fresco\Contracts\Application;
use Throwable;

class HandleExceptions implements Bootstrapper
{
    /**
     * @var Application
     */
    private $app;

    /**
     * RegisterDefinitions constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Bootstrap
     * @return mixed
     */
    public function bootstrap()
    {
        error_reporting(-1);

        ini_set('display_errors', 'Off');

        set_error_handler([$this, 'handleError']);

        set_exception_handler([$this, 'handleException']);

        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * @param        $level
     * @param        $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     *
     * @throws ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * @param Throwable $e
     */
    public function handleException(Throwable $e)
    {
        echo $e->getMessage();
    }

    /**
     * Handle PHP shutdown event
     */
    public function handleShutdown()
    {
        if (!is_null($error = error_get_last())) {
            $this->handleException(
                new ErrorException($error['message'], $error['type'], 0, $error['file'], $error['line'])
            );
        }
    }
}
