<?php

namespace Fresco\Tests\Foundation\Bootstrappers;

use Fresco\Contracts\Application;
use Fresco\Contracts\Config\Config;
use Fresco\Foundation\Bootstrap\LoadConfiguration;
use Fresco\Tests\ClosesMockeryOnTearDown;
use Mockery\Mock;

class LoadConfigurationTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var LoadConfiguration
     */
    private $bootstrapper;

    /**
     * @var Mock
     */
    private $app;

    /**
     * @var Mock
     */
    private $config;

    public function setUp()
    {
        $this->app = \Mockery::mock(Application::class);

        $this->bootstrapper = new LoadConfiguration(
            $this->config = \Mockery::mock(Config::class)
        );
    }

    public function test_it_loads_configuration()
    {
        $this->app->shouldReceive('configPath')->once()->andReturn(__DIR__ . '/../../fixtures/config');
        $this->app->shouldReceive('setEnvironment')->once()->with('production');

        $this->config->shouldReceive('set')->with('stub', ['some' => 'value'])->once();
        $this->config->shouldReceive('get')->with('app.env', 'production')->once()->andReturn('production');
        $this->config->shouldReceive('get')->with('app.timezone', 'UTC')->once()->andReturn('UTC');

        $this->bootstrapper->bootstrap($this->app);
    }
}
