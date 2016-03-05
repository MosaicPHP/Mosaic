<?php

namespace Mosaic\Routing;

use UnexpectedValueException;

class Route
{
    /**
     * The URI pattern the route responds to.
     *
     * @var string
     */
    protected $uri;

    /**
     * The HTTP methods the route responds to.
     *
     * @var array
     */
    protected $methods;

    /**
     * The route action array.
     *
     * @var array
     */
    protected $action;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * Create a new Route instance.
     *
     * @param array         $methods
     * @param string        $uri
     * @param Closure|array $action
     *
     * @throws UnexpectedValueException
     */
    public function __construct($methods, $uri, $action)
    {
        $this->setUri($uri);
        $this->methods         = (array)$methods;

        $this->action = $this->parseAction($action);

        if (in_array('GET', $this->methods) && !in_array('HEAD', $this->methods)) {
            $this->methods[] = 'HEAD';
        }
    }

    /**
     * @param array $parameters
     */
    public function bind(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Parse the route action into a standard array.
     *
     * @param callable|array $action
     *
     * @throws UnexpectedValueException
     * @return array
     */
    protected function parseAction($action)
    {
        if (is_callable($action)) {
            $action = ['uses' => $action];
        } elseif (is_string($action)) {
            $action = ['uses' => $action];
        }

        if (is_string($action['uses']) && strpos($action['uses'], '@') == 0) {
            throw new UnexpectedValueException(sprintf(
                'Invalid route action: [%s]', $action['uses']
            ));
        }

        return $action;
    }

    /**
     * @return array
     */
    public function methods() : array
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function uri() : string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function action() : array
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function parameters() : array
    {
        return $this->parameters;
    }

    /**
     * @param $uri
     */
    public function setUri(string $uri)
    {
        $this->uri = '/' . trim($uri, '/');
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasParameter(string $name)
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function parameter(string $name)
    {
        return $this->parameters[$name];
    }
}
