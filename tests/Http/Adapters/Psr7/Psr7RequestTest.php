<?php
namespace Tests\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Request;
use Fresco\Http\Adapters\Psr7\Psr7Request;
use Psr\Http\Message\RequestInterface;

class Psr7RequestTest extends \PHPUnit_Framework_TestCase
{
    function test_it_implements_the_fresco_request_interface()
    {
        $this->assertInstanceOf(Request::class, new Psr7Request(\Mockery::mock(RequestInterface::class)));
    }

    function test_it_implements_the_psr7_request_interface_for_internal_usage()
    {
        $this->assertInstanceOf(RequestInterface::class, new Psr7Request(\Mockery::mock(RequestInterface::class)));
    }
}
