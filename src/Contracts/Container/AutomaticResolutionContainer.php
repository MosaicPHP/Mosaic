<?php

namespace Mosaic\Contracts\Container;

interface AutomaticResolutionContainer extends Container
{
    /**
     * Resolve the given type from the container automatically.
     *
     * @param string $abstract
     * @param array  $parameters
     *
     * @return mixed
     */
    public function make($abstract, array $parameters = []);
}
