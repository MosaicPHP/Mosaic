<?php

namespace Fresco\Foundation\Components;

use Interop\Container\Definition\DefinitionProviderInterface;

class Registry
{
    /**
     * @var array
     */
    protected static $definitions = [];

    /**
     * @param DefinitionProviderInterface $definition
     */
    public function define(DefinitionProviderInterface $definition)
    {
        foreach ($definition->getDefinitions() as $abstract => $concrete) {
            $this->registerDefinition($abstract, $concrete);
        }
    }

    /**
     * @param string $as
     * @param object $define
     */
    private function registerDefinition($as, $define)
    {
        self::$definitions[$as] = $define;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return self::$definitions;
    }

    /**
     * Flush the registry
     */
    public static function flush()
    {
        static::$definitions = [];
    }
}
