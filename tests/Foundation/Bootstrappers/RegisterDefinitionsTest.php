<?php

namespace Fresco\Tests\Foundation\Bootstrappers;

use Fresco\Contracts\Application;
use Fresco\Contracts\Container\Container;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Registry;

class RegisterDefinitionsTest extends \PHPUnit_Framework_TestCase
{
    public $bootstrapper;

    public $app;

    public function setUp()
    {
        $this->bootstrapper = $bootstrapper = new RegisterDefinitions(
            $this->app = \Mockery::mock(Application::class)
        );
    }

    public function test_it_registers_definitions()
    {
        $this->app->shouldReceive('getRegistry')->once()->andReturn($registry = \Mockery::mock(Registry::class));
        $registry->shouldReceive('getDefinitions')->once()->andReturn([
            'abstract' => 'concrete'
        ]);

        $this->app->shouldReceive('getContainer')->once()->andReturn($container = \Mockery::mock(Container::class));
        $container->shouldReceive('instance')->once()->with('abstract', 'concrete');

        $this->bootstrapper->bootstrap();
    }
}
