<?php

namespace Mosaic\Http;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Http\Emitter;
use Mosaic\Contracts\Http\Request;
use Mosaic\Contracts\Http\Server as ServerContract;
use Mosaic\Exceptions\Formatters\SmartFormatter;
use Mosaic\Exceptions\Handlers\LogHandler;
use Mosaic\Exceptions\Runner;
use Mosaic\Http\Middleware\DispatchRequest;
use Throwable;

class Server implements ServerContract
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $middleware = [
        DispatchRequest::class,
    ];

    /**
     * @var string
     */
    protected $exceptionFormatter = SmartFormatter::class;

    /**
     * @var array
     */
    protected $exceptionHandlers = [
        LogHandler::class
    ];

    /**
     * @var Emitter
     */
    protected $emitter;

    /**
     * Server constructor.
     *
     * @param Application $app
     * @param Emitter     $emitter
     */
    public function __construct(Application $app, Emitter $emitter = null)
    {
        $this->app     = $app;
        $this->emitter = $emitter ?: new SapiEmitter;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return 'web';
    }

    /**
     * Listen to a server request
     *
     * @param callable $terminate
     */
    public function listen(callable $terminate = null)
    {
        $this->app->setExceptionRunner(
            new Runner(
                $this->app,
                $this->getEmitter(),
                $this->getExceptionHandlers(),
                $this->getExceptionFormatter()
            )
        );

        $this->app->setContext($this->getName());

        $this->app->bootstrap();

        try {
            $this->handle($terminate);
        } catch (Throwable $e) {
            $this->app->getExceptionRunner()->handleException($e);
        }
    }

    /**
     * @param callable $terminate
     */
    protected function handle(callable $terminate = null)
    {
        // Capture the request
        $request = $this->request();

        ob_start();
        $bufferLevel = ob_get_level();

        // Run the request through the stack of middleware
        $response = (new Stack($this->app))->run($request)->through(
            $this->middleware()
        );

        // Call the terminate closure when given
        if (is_callable($terminate)) {
            $terminate($request, $response);
        }

        // Emit the response
        $this->getEmitter()->emit($response, $bufferLevel);
    }

    /**
     * @return Request
     */
    protected function request() : Request
    {
        return $this->app->getContainer()->make(Request::class);
    }

    /**
     * @return array
     */
    protected function middleware() : array
    {
        return $this->middleware;
    }

    /**
     * @return Emitter
     */
    protected function getEmitter() : Emitter
    {
        return $this->emitter;
    }

    /**
     * @return mixed
     */
    protected function getExceptionFormatter()
    {
        return $this->exceptionFormatter;
    }

    /**
     * @return array
     */
    protected function getExceptionHandlers()
    {
        return $this->exceptionHandlers;
    }
}
