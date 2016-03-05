<?php

namespace Mosaic\Tests\Foundation\Bootstrappers;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Container\Container;
use Mosaic\Foundation\Bootstrap\RegisterDefinitions;
use Mosaic\Foundation\Components\Registry;
use Mosaic\Tests\ClosesMockeryOnTearDown;

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
