<?php

namespace Mosaic\Tests\Routing;

use Mosaic\Routing\Route;
use Mosaic\Routing\RouteCollection;

class RouteCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function test_can_add_a_route_to_the_collection()
    {
        $collection = new RouteCollection();
        $collection->add(new Route(['GET'], '/', function () {
        }));
    }

    public function test_can_iterate_the_collection()
    {
        $route = new Route(['GET'], '/', function () {
        });

        $collection = new RouteCollection();
        $collection->add($route);

        foreach ($collection as $cRoute) {
            $this->assertEquals($route, $cRoute);
        }
    }
}
