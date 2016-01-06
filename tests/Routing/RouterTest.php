<?php

namespace Fresco\Tests\Routing;

use Fresco\Routing\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
   public function test_can_add_get_route()
   {
       $router = new Router();

       $this->assertCount(0, $router->all());

       $router->get('/', 'HomeController@index');

       $this->assertCount(1, $router->all());
   }

    public function test_can_add_post_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->post('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_put_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->put('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_patch_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->patch('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_delete_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->delete('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_options_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->options('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_any_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->any('/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }

    public function test_can_add_match_route()
    {
        $router = new Router();

        $this->assertCount(0, $router->all());

        $router->match(['GET'], '/', 'HomeController@index');

        $this->assertCount(1, $router->all());
    }
}
