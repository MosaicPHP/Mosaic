<?php

namespace Mosaic\Routing\Dispatchers;

use Mosaic\Routing\MethodParameterResolver;
use Mosaic\Routing\Route;
use ReflectionFunction;

class DispatchClosure
{
    /**
     * @var MethodParameterResolver
     */
    private $resolver;

    /**
     * @param MethodParameterResolver $resolver
     */
    public function __construct(MethodParameterResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Dispatch the request
     *
     * @param Route $route
     *
     * @return mixed
     */
    public function dispatch(Route $route)
    {
        $action   = $route->action();
        $callback = $action['uses'];

        $parameters = $this->resolver->resolve(
            new ReflectionFunction($callback),
            $route->parameters()
        );

        return call_user_func_array($callback, $parameters);
    }

    /**
     * @param Route $route
     *
     * @return bool
     */
    public function isSatisfiedBy(Route $route)
    {
        $action = $route->action();

        return is_callable($action['uses']);
    }
}
