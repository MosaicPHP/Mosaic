<?php

namespace Fresco\Foundation\Components;

use Fresco\Contracts\Container\Container;
use LogicException;

class Registry
{
    /**
     * @var array
     */
    protected static $definitions = [];

    /**
     * @param Definition $definition
     */
    public function define(Definition $definition)
    {
        $this->registerDefinition($definition->defineAs(), $definition->define());
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
     * @throws LogicException
     *
     * @return Container
     */
    public function getContainer()
    {
        if (!isset(self::$definitions[Container::class])) {
            throw new LogicException('Container was not defined');
        }

        return self::$definitions[Container::class];
    }

    /**
     * Flush the registry
     */
    public static function flush()
    {
        static::$definitions = [];
    }
}
