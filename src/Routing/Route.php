<?php

namespace Fresco\Routing;

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
     * The default values for the route.
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * The regular expression requirements.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * The array of matched parameters.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The parameter names for the route.
     *
     * @var array|null
     */
    protected $parameterNames;

    /**
     * @var array
     */
    private $groupAttributes;

    /**
     * Create a new Route instance.
     *
     * @param array         $methods
     * @param string        $uri
     * @param Closure|array $action
     * @param array         $groupAttributes
     *
     * @throws UnexpectedValueException
     */
    public function __construct($methods, $uri, $action, array $groupAttributes = [])
    {
        $this->uri             = $uri;
        $this->methods         = (array)$methods;
        $this->groupAttributes = $groupAttributes;

        //$this->action = $this->parseAction($action);

        if (in_array('GET', $this->methods) && !in_array('HEAD', $this->methods)) {
            $this->methods[] = 'HEAD';
        }

        //if (isset($this->action['prefix'])) {
        //    $this->prefix($this->action['prefix']);
        //}
    }

    /**
     * @return array
     */
    public function methods()
    {
        return $this->methods;
    }

    /**
     * @return string
     */
    public function uri()
    {
        return $this->uri;
    }
}
