<?php

namespace Mosaic\Container\Adapters\Laravel;

use Mosaic\Container\NotFoundException;
use Mosaic\Contracts\Container\AutomaticResolutionContainer;
use Illuminate\Container\Container as LaravelContainer;

class Container implements AutomaticResolutionContainer
{
    /**
     * @var LaravelContainer
     */
    private $delegate;

    /**
     * Container constructor.
     *
     * @param LaravelContainer $delegate
     */
    public function __construct(LaravelContainer $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Resolve the given type from the container.
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed
     */
    public function make($abstract, array $parameters = [])
    {
        return $this->delegate->make($abstract, $parameters);
    }

    /**
     * Call the given Closure / class@method and inject its dependencies.
     *
     * @param callable|string $callback
     * @param array           $parameters
     * @param string|null     $defaultMethod
     *
     * @return mixed
     */
    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        return $this->delegate->call($callback, $parameters, $defaultMethod);
    }

    /**
     * Register a binding with the container.
     *
     * @param string|array         $abstract
     * @param callable|string|null $concrete
     */
    public function bind($abstract, $concrete = null)
    {
        $this->delegate->bind($abstract, $concrete);
    }

    /**
     * Register a shared binding in the container.
     *
     * @param string|array         $abstract
     * @param callable|string|null $concrete
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->delegate->singleton($abstract, $concrete);
    }

    /**
     * Determine if the given type has been bound.
     *
     * @param string $abstract
     *
     * @return bool
     */
    public function has($abstract)
    {
        return $this->delegate->bound($abstract);
    }

    /**
     * Alias a type to a different name.
     *
     * @param string $abstract
     * @param string $alias
     */
    public function alias($abstract, $alias)
    {
        $this->delegate->alias($abstract, $alias);
    }

    /**
     * Register an existing instance as shared in the container.
     *
     * @param string $abstract
     * @param mixed  $instance
     */
    public function instance($abstract, $instance)
    {
        $this->delegate->instance($abstract, $instance);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @throws NotFoundException
     * @return mixed
     */
    public function get($abstract, array $parameters = [])
    {
        if (! $this->delegate->bound($abstract)) {
            throw NotFoundException::notBound($abstract);
        }

        return $this->delegate->make($abstract, $parameters);
    }
}
