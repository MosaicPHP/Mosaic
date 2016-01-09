<?php

namespace Fresco\Tests\Foundation\Bootstrappers;

use Fresco\Contracts\Application;
use Fresco\Contracts\Container\Container;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Registry;
use Fresco\Tests\ClosesMockeryOnTearDown;

class RegisterDefinitionsTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    public $bootstrapper;

    public $app;

    public $container;

    public function setUp()
    {
        $this->app       = \Mockery::mock(Application::class);
        $this->container = \Mockery::mock(Container::class);

        $this->bootstrapper = new RegisterDefinitions($this->container);
    }

    public function test_it_registers_definitions()
    {
        $this->app->shouldReceive('getRegistry')->once()->andReturn($registry = \Mockery::mock(Registry::class));
        $registry->shouldReceive('getDefinitions')->once()->andReturn([
            'abstract' => 'concrete'
        ]);

        $this->container->shouldReceive('bind')->once()->with('abstract', 'concrete');

        $this->bootstrapper->bootstrap($this->app);
    }
}
