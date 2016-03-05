<?php

namespace Mosaic\Definitions;

use Mosaic\CommandBus\Tactician\HandlerLocator;
use Mosaic\CommandBus\Tactician\TacticianBus;
use Mosaic\Contracts\Application;
use Mosaic\Contracts\CommandBus\CommandBus;
use Mosaic\Contracts\Container\Container;
use Interop\Container\Definition\DefinitionProviderInterface;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

class TacticianDefinition implements DefinitionProviderInterface
{
    /**
     * @var Application
     */
    private $app;

    /**
     * TacticianDefinition constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Returns the definition to register in the container.
     *
     * Definitions must be indexed by their entry ID. For example:
     *
     *     return [
     *         'logger' => ...
     *         'mailer' => ...
     *     ];
     *
     * @return array
     */
    public function getDefinitions()
    {
        return [
            CommandBus::class => function () {
                return new TacticianBus(
                    $this->app->getContainer(),
                    [
                        new CommandHandlerMiddleware(
                            new ClassNameExtractor(),
                            new HandlerLocator($this->app->getContainer()),
                            new HandleInflector()
                        )
                    ]
                );
            }
        ];
    }
}
