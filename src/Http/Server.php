<?php

namespace Fresco\Http;

use Fresco\Contracts\Application;
use Fresco\Contracts\Http\Emitter;
use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\Server as ServerContract;
use Fresco\Exceptions\Formatters\EnvBasedWhoopsFormatter;
use Fresco\Exceptions\Handlers\LogHandler;
use Fresco\Exceptions\Runner;
use Fresco\Http\Middleware\DispatchRequest;
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
     * @var
     */
    protected $exceptionFormatter = EnvBasedWhoopsFormatter::class;

    /**
     * @var array
     */
    protected $exceptionHandlers = [
        LogHandler::class
    ];

    /**
     * Server constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     *
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
        return new SapiEmitter;
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
