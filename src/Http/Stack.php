<?php

namespace Mosaic\Http;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Http\Request;
use Mosaic\Contracts\Http\Response;

class Stack
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Application
     */
    private $app;

    /**
     * Stack constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     *
     * @return Stack
     */
    public function run(Request $request) : Stack
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param array $middleware
     *
     * @return Response
     */
    public function through(array $middleware) : Response
    {
        $stack = array_reverse($middleware);

        return array_reduce($stack, $this->send());
    }

    /**
     * @return callable
     */
    protected function send() : callable
    {
        return function ($next, $pipe) {
            $run = $this->app->getContainer()->make($pipe);

            return $run($this->request, function () use ($next) {
                return $next;
            });
        };
    }
}
