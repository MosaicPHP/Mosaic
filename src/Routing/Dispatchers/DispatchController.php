<?php

namespace Fresco\Routing\Dispatchers;

use Fresco\Contracts\Container\Container;
use Fresco\Exceptions\NotFoundHttpException;
use Fresco\Routing\MethodParameterResolver;
use Fresco\Routing\Route;
use ReflectionMethod;

class DispatchController
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var MethodParameterResolver
     */
    private $resolver;

    /**
     * @param Container               $container
     * @param MethodParameterResolver $resolver
     */
    public function __construct(Container $container, MethodParameterResolver $resolver)
    {
        $this->container = $container;
        $this->resolver  = $resolver;
    }

    /**
     * Dispatch the request
     *
     * @param Route $route
     *
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function dispatch(Route $route)
    {
        $action = $route->action();

        list($class, $method) = explode('@', $action['uses']);

        if (!method_exists($instance = $this->container->make($class), $method)) {
            throw new NotFoundHttpException;
        }

        $parameters = $this->resolver->resolve(
            new ReflectionMethod($instance, $method),
            $route->parameters()
        );

        return $this->container->call([$instance, $method], $parameters);
    }
}
