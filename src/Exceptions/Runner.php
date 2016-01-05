<?php

namespace Fresco\Exceptions;

use ErrorException;
use Fresco\Contracts\Application;
use Fresco\Contracts\Exceptions\ExceptionRunner;
use Fresco\Exceptions\Formatters\HtmlFormatter;
use Throwable;

abstract class Runner implements ExceptionRunner
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $formatter = HtmlFormatter::class;

    /**
     * @var string[]
     */
    protected $handlers = [];

    /**
     * @var array
     */
    protected $shouldNotHandle = [];

    /**
     * Handler constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $formatter
     */
    public function setFormatter(string $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param string $formatter
     */
    public function addHandler(string $handler)
    {
        $this->handlers[] = $handler;
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
        if (!in_array(get_class($e), $this->shouldNotHandle)) {
            foreach ($this->handlers as $handler) {
                $handler = $this->app->getContainer()->make($handler);
                $handler->handle($e);
            }
        }

        return $this->app->getContainer()->make($this->formatter)->render($e);
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
