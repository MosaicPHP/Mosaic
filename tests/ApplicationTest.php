<?php

namespace Fresco\Tests;

use Fresco\Application;
use Fresco\Contracts\Container\Container;
use Fresco\Contracts\Container\ContainerDefinition;
use Fresco\Contracts\Exceptions\ExceptionRunner;
use Fresco\Foundation\Bootstrap\Bootstrapper;
use Fresco\Foundation\Bootstrap\HandleExceptions;
use Fresco\Foundation\Bootstrap\LoadConfiguration;
use Fresco\Foundation\Bootstrap\LoadEnvironmentVariables;
use Fresco\Foundation\Bootstrap\LoadRoutes;
use Fresco\Foundation\Bootstrap\RegisterDefinitions;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\Registry;
use Interop\Container\Definition\DefinitionProviderInterface;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    public function test_it_inits_a_registry_when_application_is_first_created()
    {
        $app = new Application(__DIR__);

        $this->assertInstanceOf(Registry::class, $app->getRegistry());
    }

    public function test_can_get_path()
    {
        $path = __DIR__;
        $app  = new Application($path);

        $this->assertEquals($path, $app->path());
        $this->assertEquals($path . '/path', $app->path('path'));
    }

    public function test_can_get_config_path()
    {
        $path = __DIR__;
        $app  = new Application($path);

        $this->assertEquals($path . '/config', $app->configPath());
        $this->assertEquals($path . '/config/path', $app->configPath('path'));
    }

    public function test_can_get_storage_path()
    {
        $path = __DIR__;
        $app  = new Application($path);

        $this->assertEquals($path . '/storage', $app->storagePath());
        $this->assertEquals($path . '/storage/path', $app->storagePath('path'));
    }

    public function test_can_get_views_path()
    {
        $path = __DIR__;
        $app  = new Application($path);

        $this->assertEquals($path . '/resources/views', $app->viewsPath());
        $this->assertEquals($path . '/resources/views/path', $app->viewsPath('path'));
    }

    public function test_it_defines_a_default_container_when_application_is_first_created()
    {
        $app = new Application(__DIR__);

        $this->assertInstanceOf(Container::class, $app->getContainer());
    }

    public function test_can_set_a_custom_container_definition()
    {
        $app = new Application(__DIR__, ContainerDefinitionStub::class);

        $this->assertInstanceOf(Container::class, $app->getContainer());
        $this->assertEquals(ContainerDefinitionStub::$mockInstance, $app->getContainer());
    }

    public function test_can_define_a_custom_container_definition()
    {
        $app = new Application(__DIR__);
        $app->defineContainer(new ContainerDefinitionStub);

        $this->assertInstanceOf(Container::class, $app->getContainer());
        $this->assertEquals(ContainerDefinitionStub::$mockInstance, $app->getContainer());
    }

    public function test_application_can_define_some_component()
    {
        $app = new Application(__DIR__);
        $app->define(new SomeDefinitionStub);

        $this->assertEquals('concrete', $app->getRegistry()->getDefinitions()['abstract']);
    }

    public function test_can_define_multiple_definitions_at_onces()
    {
        $app = new Application(__DIR__);
        $app->definitions([
            SomeDefinitionStub::class
        ]);

        $this->assertEquals('concrete', $app->getRegistry()->getDefinitions()['abstract']);
    }

    public function test_will_delegate_on_all_configured_bootstrappers_to_bootstrap()
    {
        $app = new Application(__DIR__, ContainerDefinitionStub::class);

        $mockBootstrapper = \Mockery::mock(Bootstrapper::class);
        $mockBootstrapper->shouldReceive('bootstrap')->times(5);

        ContainerDefinitionStub::$mockInstance->shouldReceive('make')->with(RegisterDefinitions::class)
                                              ->once()->andReturn($mockBootstrapper);
        ContainerDefinitionStub::$mockInstance->shouldReceive('make')->with(HandleExceptions::class)
                                              ->once()->andReturn($mockBootstrapper);
        ContainerDefinitionStub::$mockInstance->shouldReceive('make')->with(LoadConfiguration::class)
                                              ->once()->andReturn($mockBootstrapper);
        ContainerDefinitionStub::$mockInstance->shouldReceive('make')->with(LoadEnvironmentVariables::class)
                                              ->once()->andReturn($mockBootstrapper);
        ContainerDefinitionStub::$mockInstance->shouldReceive('make')->with(LoadRoutes::class)
                                              ->once()->andReturn($mockBootstrapper);

        $app->bootstrap();
    }

    public function test_can_set_environment()
    {
        $app = new Application(__DIR__);

        $app->setEnvironment('some_env');

        $this->assertEquals('some_env', $app->env());
    }

    public function test_can_check_if_env_is_local()
    {
        $app = new Application(__DIR__);

        $this->assertFalse($app->isLocal());

        $app->setEnvironment('local');

        $this->assertTrue($app->isLocal());
    }

    public function test_can_bind_an_exception_runner()
    {
        $app = new Application(__DIR__);

        $app->setExceptionRunner(
            $runner = \Mockery::mock(ExceptionRunner::class)
        );

        $this->assertEquals($runner, $app->getExceptionRunner());
    }

    public function test_can_set_context()
    {
        $app = new Application(__DIR__);
        $app->setContext('web');

        $this->assertEquals('web', $app->getContext());
    }

    public function tearDown()
    {
        parent::tearDown();

        Registry::flush();
    }
}

class ContainerDefinitionStub implements ContainerDefinition
{
    /**
     * @var MockInterface
     */
    public static $mockInstance;

    /**
     * @return Container
     */
    public function getDefinition() : Container
    {
        self::$mockInstance = \Mockery::mock(Container::class);
        self::$mockInstance->shouldReceive('instance');

        return self::$mockInstance;
    }
}

class SomeDefinitionStub implements DefinitionProviderInterface
{
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
            'abstract' => 'concrete'
        ];
    }
}

class ERunner extends \Fresco\Exceptions\Runner
{
}
