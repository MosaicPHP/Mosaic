<?php

namespace Mosaic\Exceptions;

use ErrorException;
use Mosaic\Contracts\Application;
use Mosaic\Contracts\Exceptions\ExceptionRunner;
use Mosaic\Contracts\Http\Emitter;
use Mosaic\Contracts\Http\ResponseFactory;
use Mosaic\Exceptions\Formatters\HtmlFormatter;
use Throwable;

class Runner implements ExceptionRunner
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
     * @var Emitter
     */
    protected $emitter;

    /**
     * Handler constructor.
     *
     * @param Application $app
     * @param Emitter     $emitter
     * @param array       $handlers
     * @param string      $formatter
     */
    public function __construct(
        Application $app,
        Emitter $emitter,
        array $handlers = [],
        string $formatter = HtmlFormatter::class
    ) {
        $this->app       = $app;
        $this->formatter = $formatter;
        $this->handlers  = $handlers;
        $this->emitter   = $emitter;
    }

    /**
     * @param string $formatter
     */
    public function setFormatter(string $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * @param string $handler
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
                $this->handle($e, $handler);
            }
        }

        $error = $this->render($e);

        $response = $this->factory()->make(
            $error->getOutput(),
            $error->getStatus()
        );

        $this->emitter->emit($response);
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

    /**
     * @return ResponseFactory
     */
    private function factory()
    {
        return $this->app->getContainer()->make(ResponseFactory::class);
    }

    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    private function render(Throwable $e)
    {
        return $this->app->getContainer()->make($this->formatter)->render($e);
    }

    /**
     * @param Throwable $e
     * @param           $handler
     */
    private function handle(Throwable $e, $handler)
    {
        $handler = $this->app->getContainer()->make($handler);
        $handler->handle($e);
    }
}
