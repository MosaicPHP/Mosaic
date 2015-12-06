<?php
namespace Tests\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Request;
use Fresco\Http\Adapters\Psr7\Psr7Request;
use Psr\Http\Message\RequestInterface;

class Psr7RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var RequestInterface|\Mockery\MockInterface
     */
    private $wrappedMock;

    protected function setUp()
    {
        $this->request = new Psr7Request($this->wrappedMock = \Mockery::mock(RequestInterface::class));
    }

    function test_it_implements_the_fresco_request_interface()
    {
        $this->assertInstanceOf(Request::class, $this->request);
    }

    function test_it_implements_the_psr7_request_interface_for_internal_usage()
    {
        $this->assertInstanceOf(RequestInterface::class, $this->request);
    }

    function test_extract_an_existing_and_single_item_header_from_a_request_returns_the_item()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn(['text/html']);

        $this->assertEquals('text/html', $this->request->header('accept'));
    }

    function test_extract_an_existing_and_multi_item_header_from_a_request_returns_all_the_items()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn(['text/html', 'text/plain']);

        $this->assertEquals(['text/html', 'text/plain'], $this->request->header('accept'));
    }

    function test_extract_a_non_existing_header_from_a_request_returns_null()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn([]);

        $this->assertNull($this->request->header('accept'));
    }

    function test_extract_a_non_existing_header_with_a_default_value_from_a_request_returns_the_default_value()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn([]);

        $this->assertEquals('text/css', $this->request->header('accept', 'text/css'));
    }
}
