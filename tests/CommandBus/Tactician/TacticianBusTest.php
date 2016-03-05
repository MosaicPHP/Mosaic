<?php

namespace Mosaic\Tests\CommandBus\Tactician;

use Mosaic\CommandBus\Tactician\HandlerLocator;
use Mosaic\CommandBus\Tactician\TacticianBus;
use Mosaic\Support\ArrayObject;
use Mosaic\Tests\ClosesMockeryOnTearDown;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Plugins\LockingMiddleware;
use Mockery\Mock;
use PHPUnit_Framework_TestCase;

class TacticianBusTest extends PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var Mock
     */
    protected $container;

    /**
     * @var TacticianBus
     */
    protected $bus;

    public function setUp()
    {
        $this->container = \Mockery::mock(\Mosaic\Contracts\Container\Container::class);

        $this->bus = new TacticianBus(
            $this->container,
            [
                new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new HandlerLocator($this->container),
                    new HandleInflector()
                )
            ]
        );
    }

    public function test_can_dispatch_command_object_instance()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);

        $result = $this->bus->dispatch(new TacticianCommand);

        $this->assertEquals('handled', $result);
    }

    public function test_can_dispatch_command_as_string_with_array_object()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);

        $result = $this->bus->dispatchFrom(TacticianCommand::class, new ArrayObject());

        $this->assertEquals('handled', $result);
    }

    public function test_can_dispatch_command_as_string_from_array()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);

        $result = $this->bus->dispatchFromArray(TacticianCommand::class, []);

        $this->assertEquals('handled', $result);
    }

    public function test_can_pass_middleware_during_dispatch()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);
        $this->container->shouldReceive('make')->with(LockingMiddleware::class)->once()->andReturn(new LockingMiddleware);

        $result = $this->bus->dispatch(new TacticianCommand, [
            LockingMiddleware::class
        ]);

        $this->assertEquals('handled', $result);
    }

    public function test_can_pass_middleware_during_dispatch_from_array_object()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);
        $this->container->shouldReceive('make')->with(LockingMiddleware::class)->once()->andReturn(new LockingMiddleware);

        $result = $this->bus->dispatchFrom(TacticianCommand::class, new ArrayObject(), [], [
            LockingMiddleware::class
        ]);

        $this->assertEquals('handled', $result);
    }

    public function test_can_pass_middleware_during_dispatch_from_array()
    {
        $this->container->shouldReceive('make')->with(TacticianCommandHandler::class)->once()->andReturn(new TacticianCommandHandler);
        $this->container->shouldReceive('make')->with(LockingMiddleware::class)->once()->andReturn(new LockingMiddleware);

        $result = $this->bus->dispatchFromArray(TacticianCommand::class, [], [
            LockingMiddleware::class
        ]);

        $this->assertEquals('handled', $result);
    }
}

class TacticianCommand
{
}

class TacticianCommandHandler
{
    public function handle(TacticianCommand $command)
    {
        return 'handled';
    }
}
