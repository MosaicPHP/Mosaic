<?php

namespace Mosaic\Tests\Routing\Loaders;

use Mosaic\Contracts\Application;
use Mosaic\Contracts\Config\Config;
use Mosaic\Contracts\Container\Container;
use Mosaic\Contracts\Routing\Router;
use Mosaic\Routing\Loaders\LoadRoutesFromBinders;
use Mosaic\Tests\fixtures\routes\StubRouteBinder;
use InvalidArgumentException;
use Mockery\Mock;
use PHPUnit_Framework_TestCase;

class LoadRoutesFromBindersTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var LoadRoutesFromBinders
     */
    private $binder;

    /**
     * @var Mock
     */
    private $app;

    /**
     * @var Mock
     */
    private $container;

    /**
     * @var Mock
     */
    private $config;

    public function setUp()
    {
        $this->binder = new LoadRoutesFromBinders(
            $this->app = \Mockery::mock(Application::class),
            $this->container = \Mockery::mock(Container::class),
            $this->config = \Mockery::mock(Config::class)
        );
    }

    public function test_it_binds_routes_using_all_route_binders_given_in_the_config()
    {
        $this->app->shouldReceive('getContext')->once()->andReturn(
            $context = 'web'
        );

        $this->config->shouldReceive('get')->once()->with($context . '.routes', [])->andReturn([
            StubRouteBinder::class
        ]);

        $this->container->shouldReceive('make')->with(StubRouteBinder::class)->once()->andReturn(
            new StubRouteBinder
        );

        $router = \Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('/', 'Controller@method')->once();

        $this->binder->loadRoutes($router);
    }

    public function test_it_throws_exception_when_route_binder_does_not_exist()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'RouteBinder [NotExistingRouteBinder] does not exist');

        $this->app->shouldReceive('getContext')->once()->andReturn(
            $context = 'web'
        );

        $this->config->shouldReceive('get')->once()->with($context . '.routes', [])->andReturn([
            \NotExistingRouteBinder::class
        ]);

        $this->binder->loadRoutes(
            \Mockery::mock(Router::class)
        );
    }
}
