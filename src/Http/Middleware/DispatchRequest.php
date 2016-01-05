<?php

namespace Fresco\Http\Middleware;

use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\ResponseFactory;
use Fresco\Http\Adapters\Psr7\Response;

class DispatchRequest
{
    /**
     * @var ResponseFactory
     */
    private $factory;

    /**
     * DispatchRequest constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Dispatch the request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return $this->factory->html($request->get('name', 'No name given'));
    }
}
