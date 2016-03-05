<?php

namespace Mosaic\Tests\Routing;

use Mosaic\Routing\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function test_can_create_a_get_route()
    {
        $route = new Route(['GET'], '/', function () {
        });

        $this->assertEquals(['GET', 'HEAD'], $route->methods());
        $this->assertEquals('/', $route->uri());
        $this->assertTrue(is_callable($route->action()['uses']));
    }

    public function test_can_create_a_post_route()
    {
        $route = new Route(['POST'], '/', function () {
        });

        $this->assertEquals(['POST'], $route->methods());
        $this->assertEquals('/', $route->uri());
        $this->assertTrue(is_callable($route->action()['uses']));
    }

    public function test_can_create_a_put_route()
    {
        $route = new Route(['PUT'], '/', function () {
        });

        $this->assertEquals(['PUT'], $route->methods());
        $this->assertEquals('/', $route->uri());
        $this->assertTrue(is_callable($route->action()['uses']));
    }

    public function test_can_create_a_delete_route()
    {
        $route = new Route(['DELETE'], '/', function () {
        });

        $this->assertEquals(['DELETE'], $route->methods());
        $this->assertEquals('/', $route->uri());
        $this->assertTrue(is_callable($route->action()['uses']));
    }

    public function test_uri_is_prepended_with_slash()
    {
        $route = new Route(['GET'], '/', function () {
        });
        $this->assertEquals('/', $route->uri());

        $route = new Route(['GET'], 'test', function () {
        });
        $this->assertEquals('/test', $route->uri());

        $route = new Route(['GET'], '/test', function () {
        });
        $this->assertEquals('/test', $route->uri());
    }

    public function test_action_gets_transformed_to_array()
    {
        $route = new Route(['GET'], '/', function () {
        });
        $this->assertTrue(is_array($route->action()));
        $this->assertTrue(isset($route->action()['uses']));
        $this->assertTrue(is_callable($route->action()['uses']));

        $route = new Route(['GET'], '/', 'HomeController@index');
        $this->assertTrue(is_array($route->action()));
        $this->assertTrue(isset($route->action()['uses']));
        $this->assertEquals('HomeController@index', $route->action()['uses']);

        $route = new Route(['GET'], '/', [
            'uses' => 'HomeController@index'
        ]);
        $this->assertTrue(is_array($route->action()));
        $this->assertTrue(isset($route->action()['uses']));
        $this->assertEquals('HomeController@index', $route->action()['uses']);
    }

    public function test_given_action_should_be_valid()
    {
        $this->setExpectedException(\UnexpectedValueException::class, 'Invalid route action: [HomeController]');

        new Route(['GET'], '/', 'HomeController');
    }

    public function test_can_bind_parameters_to_route()
    {
        $route = new Route(['GET'], '{id}', 'HomeController@index');
        $route->bind([
            'id' => 1
        ]);

        $this->assertEquals(['id' => 1], $route->parameters());
    }

    public function test_can_check_if_parameter_exists()
    {
        $route = new Route(['GET'], '{id}', 'HomeController@index');
        $route->bind([
            'id' => 1
        ]);

        $this->assertTrue($route->hasParameter('id'));
        $this->assertFalse($route->hasParameter('foo'));
    }

    public function test_can_get_parameter()
    {
        $route = new Route(['GET'], '{id}', 'HomeController@index');
        $route->bind([
            'id' => 1
        ]);

        $this->assertEquals(1, $route->parameter('id'));
    }
}
