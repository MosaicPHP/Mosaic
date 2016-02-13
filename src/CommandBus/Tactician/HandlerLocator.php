<?php

namespace Fresco\CommandBus\Tactician;

use Fresco\Contracts\Container\Container;
use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator as HandlerLocatorInterface;

class HandlerLocator implements HandlerLocatorInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Locator constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @throws MissingHandlerException
     * @return object
     */
    public function getHandlerForCommand($commandName)
    {
        $handler = $this->getHandlerClassName($commandName);

        if (!class_exists($handler)) {
            throw MissingHandlerException::forCommand($commandName);
        }

        return $this->container->make($handler);
    }

    /**
     * @param $commandName
     * @return string
     */
    protected function getHandlerClassName($commandName)
    {
        return $commandName . 'Handler';
    }
}
