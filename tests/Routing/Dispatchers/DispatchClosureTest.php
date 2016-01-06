<?php

namespace Fresco\Tests\Routing\Dispatchers;

use Fresco\Routing\Dispatchers\DispatchClosure;
use Fresco\Routing\MethodParameterResolver;
use Fresco\Routing\Route;

class DispatchClosureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MethodParameterResolver|\Mockery\Mock
     */
    private $resolver;

    /**
     * @var DispatchClosure
     */
    private $dispatcher;

    public function setUp()
    {
        $this->resolver = \Mockery::mock(MethodParameterResolver::class);
        $this->resolver->shouldReceive('resolve')->andReturn([]);

        $this->dispatcher = new DispatchClosure(
            $this->resolver
        );
    }

    public function test_can_check_if_action_needs_to_be_dispatched_as_closure()
    {
        $this->assertTrue(
            $this->dispatcher->isSatisfiedBy(new Route(['GET'], '/', function () {
            }))
        );

        $this->assertFalse(
            $this->dispatcher->isSatisfiedBy(new Route(['GET'], '/', 'Controller@index'))
        );
    }

    public function test_can_dispatch_controller()
    {
        $route = new Route(['GET'], '/', [
            'uses' => function () {
                return 'response';
            }
        ]);

        $response = $this->dispatcher->dispatch($route);

        $this->assertEquals('response', $response);
    }
}
