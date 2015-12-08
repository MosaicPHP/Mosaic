<?php

namespace Fresco\Http;

use Fresco\Contracts\Application;
use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\Server as ServerContract;

class Server implements ServerContract
{
    /**
     * @var Application
     */
    protected $app;

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
     * @param Request  $request
     * @param callable $terminate
     */
    public function listen(Request $request, callable $terminate = null)
    {
        echo 'Hello world';
    }
}
