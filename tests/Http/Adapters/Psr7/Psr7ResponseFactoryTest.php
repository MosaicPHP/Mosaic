<?php

namespace Fresco\Tests\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Response as ResponseContract;
use Fresco\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Fresco\Http\Adapters\Psr7\ResponseFactory;

class Psr7ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ResponseFactory();
    }

    public function test_it_implements_the_fresco_response_factory_interface()
    {
        $this->assertInstanceOf(ResponseFactoryContract::class, $this->factory);
    }

    public function test_can_make_200_OK_html_response()
    {
        $response = $this->factory->html('html body');

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals('html body', $response->body());
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'content-type' => ['text/html; charset=utf-8']
        ], $response->headers());
    }

    public function test_can_make_html_response_with_error_status_code()
    {
        $response = $this->factory->html('Whoops something went wrong', 500);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals('Whoops something went wrong', $response->body());
        $this->assertEquals(500, $response->status());
        $this->assertEquals([
            'content-type' => ['text/html; charset=utf-8']
        ], $response->headers());
    }

    public function test_can_make_html_response_with_custom_headers()
    {
        $response = $this->factory->html('html body', 200, [
            'custom' => 'header'
        ]);

        $this->assertInstanceOf(ResponseContract::class, $response);
        $this->assertEquals('html body', $response->body());
        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'content-type' => ['text/html; charset=utf-8'],
            'custom'       => ['header']
        ], $response->headers());
    }
}
