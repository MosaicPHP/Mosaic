<?php

namespace Mosaic\CommandBus;

use ArrayAccess;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionParameter;

class Marshal
{
    /**
     * @param  string      $command
     * @param  ArrayAccess $input
     * @param  array       $extra
     * @return object
     */
    public function getClassInstance($command, ArrayAccess $input, array $extra = [])
    {
        $injected = [];

        $reflection = new ReflectionClass($command);

        if ($constructor = $reflection->getConstructor()) {
            $injected = array_map(function ($parameter) use ($command, $input, $extra) {
                return $this->getParameterValueForCommand($input, $parameter, $extra);
            }, $constructor->getParameters());
        }

        return $reflection->newInstanceArgs($injected);
    }

    /**
     * Get a parameter value for a marshaled command.
     *
     * @param ArrayAccess         $source
     * @param ReflectionParameter $parameter
     * @param array               $extras
     *
     * @return mixed
     */
    protected function getParameterValueForCommand(
        ArrayAccess $source,
        ReflectionParameter $parameter,
        array $extras = []
    ) {
        if (array_key_exists($parameter->name, $extras)) {
            return $extras[$parameter->name];
        }

        if (isset($source[$parameter->name])) {
            return $source[$parameter->name];
        }

        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new InvalidArgumentException("Unable to map input to command: {$parameter->name}");
    }
}
