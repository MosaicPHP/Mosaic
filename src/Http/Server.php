<?php

namespace Fresco\Http;

use Fresco\Contracts\Application;
use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\Response;
use Fresco\Contracts\Http\Server as ServerContract;
use Fresco\Http\Middleware\DispatchRequest;
use Fresco\Http\Middleware\DoSomething;

class Server implements ServerContract
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $middleware = [
        DispatchRequest::class,
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
     * Listen to a server request
     *
     * @param callable $terminate
     */
    public function listen(callable $terminate = null)
    {
        // Bootstrap the application
        $this->app->bootstrap();

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
        $this->emit($response, $bufferLevel);
    }

    /**
     * @param Response $response
     * @param null     $bufferLevel
     *
     * @throws RuntimeException
     */
    private function emit(Response $response, $bufferLevel = null)
    {
        (new Emitter)->emit($response, $bufferLevel);
    }

    /**
     * @return Request
     */
    private function request() : Request
    {
        return $this->app->getContainer()->make(Request::class);
    }

    /**
     * @return array
     */
    private function middleware() : array
    {
        return $this->middleware;
    }
}
