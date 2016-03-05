<?php

namespace Mosaic\Tests\Foundation\Bootstrappers;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\EnvironmentVariablesLoader;
use Mosaic\Foundation\Bootstrap\LoadEnvironmentVariables;
use Mosaic\Tests\ClosesMockeryOnTearDown;
use Mockery\Mock;

class LoadEnvironmentVariablesTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var LoadEnvironmentVariables
     */
    private $bootstrapper;

    /**
     * @var Mock
     */
    private $app;

    /**
     * @var Mock
     */
    private $loader;

    public function setUp()
    {
        $this->app = \Mockery::mock(Application::class);

        $this->bootstrapper = new LoadEnvironmentVariables(
            $this->loader = \Mockery::mock(EnvironmentVariablesLoader::class)
        );
    }

    public function test_it_loads_configuration()
    {
        $this->app->shouldReceive('path')->once()->andReturn('some_path');
        $this->loader->shouldReceive('load')->with('some_path')->once();

        $this->bootstrapper->bootstrap($this->app);
    }
}
