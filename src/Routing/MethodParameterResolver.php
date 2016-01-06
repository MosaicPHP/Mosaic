<?php

namespace Fresco\Routing;

use Fresco\Contracts\Container\Container;
use ReflectionFunctionAbstract;

class MethodParameterResolver
{
    /**
     * @var Container
     */
    private $container;

    /**
     * MethodParameterResolver constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param ReflectionFunctionAbstract $reflector
     * @param array                      $parameters
     *
     * @return mixed
     */
    public function resolve(ReflectionFunctionAbstract $reflector, array $parameters = []) : array
    {
        $reflected = $reflector->getParameters();

        $resolved = [];
        foreach ($reflected as $param) {
            if ($class = $param->getClass()) {
                $resolved[$param->name] = $this->container->make($class->name);
            } elseif (isset($parameters[$param->name])) {
                $resolved[$param->name] = $parameters[$param->name];
            }
        }

        return $resolved;
    }
}
