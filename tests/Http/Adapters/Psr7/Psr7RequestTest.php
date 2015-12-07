<?php
namespace Fresco\Tests\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Request;
use Fresco\Http\Adapters\Psr7\Psr7Request;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Psr7RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Psr7Request
     */
    private $request;

    /**
     * @var ServerRequestInterface|\Mockery\MockInterface
     */
    private $wrappedMock;

    protected function setUp()
    {
        $this->request = new Psr7Request($this->wrappedMock = \Mockery::mock(ServerRequestInterface::class));
    }

    function test_it_implements_the_fresco_request_interface()
    {
        $this->assertInstanceOf(Request::class, $this->request);
    }

    function test_it_implements_the_psr7_server_request_interface_for_internal_usage()
    {
        $this->assertInstanceOf(ServerRequestInterface::class, $this->request);
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

    function test_can_get_the_request_method_from_it()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn($method = uniqid());

        $this->assertEquals($method, $this->request->method());
    }

    function test_immutability_on_request_target()
    {
        $this->wrappedMock->shouldReceive('withRequestTarget')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withRequestTarget('foo'));
    }

    function test_immutability_on_method()
    {
        $this->wrappedMock->shouldReceive('withMethod')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withMethod('POST'));
    }

    function test_immutability_on_uri()
    {
        $this->wrappedMock->shouldReceive('withUri')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withUri(\Mockery::mock(UriInterface::class)));
    }

    function test_immutability_on_protocol_version()
    {
        $this->wrappedMock->shouldReceive('withProtocolVersion')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withProtocolVersion('2.0'));
    }

    function test_immutability_on_header()
    {
        $this->wrappedMock->shouldReceive('withHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withHeader('cache-control', 'max-age:0'));
    }

    function test_immutability_on_added_header()
    {
        $this->wrappedMock->shouldReceive('withAddedHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withAddedHeader('cache-control', 'max-age:0'));
    }

    function test_immutability_on_without_header()
    {
        $this->wrappedMock->shouldReceive('withoutHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withoutHeader('cache-control'));
    }

    function test_immutability_on_body()
    {
        $this->wrappedMock->shouldReceive('withBody')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withBody(\Mockery::mock(StreamInterface::class)));
    }

    function test_immutability_on_cookie_params()
    {
        $this->wrappedMock->shouldReceive('withCookieParams')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withCookieParams(['cookie' => 'monster']));
    }

    function test_immutability_on_query_params()
    {
        $this->wrappedMock->shouldReceive('withQueryParams')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withQueryParams(['q' => 'Fresco is awesome!']));
    }

    function test_immutability_on_uploaded_files()
    {
        $this->wrappedMock->shouldReceive('withUploadedFiles')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withUploadedFiles(['logo.png' => 'FrescoLogo']));
    }

    function test_immutability_on_parsed_body()
    {
        $this->wrappedMock->shouldReceive('withParsedBody')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withParsedBody(['some' => 'parsed data']));
    }

    function test_immutability_on_attribute()
    {
        $this->wrappedMock->shouldReceive('withAttribute')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withAttribute('some', 'attribute'));
    }

    function test_immutability_on_without_attribute()
    {
        $this->wrappedMock->shouldReceive('withoutAttribute')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withoutAttribute('some'));
    }

    function test_can_get_request_parameters_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertEquals('bar', $this->request->get('foo'));
    }

    function test_can_get_a_default_null_value_from_a_non_existing_request_parameter_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertNull($this->request->get('baz'));
    }

    function test_can_get_a_given_default_value_from_a_non_existing_request_parameter_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertEquals($default = uniqid(), $this->request->get('baz', $default));
    }

    function test_can_get_request_parameters_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertEquals('bar', $this->request->get('foo'));
    }

    function test_can_get_a_default_null_value_from_a_non_existing_request_parameter_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertNull($this->request->get('baz'));
    }

    function test_can_get_a_given_default_value_from_a_non_existing_request_parameter_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertEquals($default = uniqid(), $this->request->get('baz', $default));
    }

    function test_on_non_get_requests_query_parameters_have_precedence_over_body_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'baz'
        ]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertEquals('baz', $this->request->get('foo'));
    }

    function test_can_obtain_all_get_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'baz'
        ]);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertEquals([
            'foo' => 'baz'
        ], $this->request->all());
    }

    function test_can_obtain_all_post_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'baz'
        ]);

        $this->assertEquals([
            'foo' => 'baz'
        ], $this->request->all());
    }

    function test_can_obtain_all_post_parameters_with_merged_ones_from_query()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'baz',
            'bar' => 'foo',
        ]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'baz',
            'barbaz' => 'foobar'
        ]);

        $this->assertEquals([
            'foo' => 'baz',
            'bar' => 'foo',
            'barbaz' => 'foobar'
        ], $this->request->all());
    }

    function test_can_obtain_only_some_parameters_from_the_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'baz' => 'fo'], $this->request->only(['foo', 'baz']));
    }

    function test_can_obtain_only_one_parameter_from_the_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar'], $this->request->only('foo'));
    }

    function test_when_obtaining_only_some_parameters_from_the_request_they_are_returned_back_as_null_if_they_dont_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(
            [
                'foo' => 'bar',
                'baz' => 'fo',
                'idontexist' => null
            ],
            $this->request->only(['foo', 'baz', 'idontexist'])
        );
    }

    function test_can_obtain_all_parameters_except_a_given_set()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $this->request->except(['baz', 'bez']));
    }

    function test_can_obtain_all_parameters_except_a_given_one()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo', 'bez' => 'fe'], $this->request->except('baz'));
    }

    function test_can_check_if_a_parameter_exists()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->exists('foo'));
    }

    function test_can_check_if_a_parameter_doesnt_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->exists('goo'));
    }

    function test_can_check_if_a_set_of_parameters_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->exists(['foo', 'bar', 'baz']));
    }

    function test_can_check_if_a_set_of_parameters_dont_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->exists(['foo', 'bar', 'bag']));
    }

    function test_can_check_if_it_has_a_non_empty_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has('foo'));
    }

    function test_can_check_if_it_doesnt_have_a_non_empty_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => '',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->has('foo'));
    }

    function test_can_check_if_it_has_a_non_empty_set_of_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => '',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->has(['foo', 'bar', 'baz']));
    }

    function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_zero_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_array_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => ['foo', 'bar'],
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_empty_array_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'bar',
            'bar' => [],
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->has(['foo', 'bar', 'baz']));
    }

    function test_can_get_server_params()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ], $this->request->server());
    }

    function test_can_get_a_specific_server_param()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals('/i/am/g/root', $this->request->server('DOCUMENT_ROOT'));
    }

    function test_will_get_null_as_default_if_a_specific_server_param_does_not_exist()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertNull($this->request->server('APP_ENGINE'));
    }

    function test_can_use_a_default_value_if_a_specific_server_param_does_not_exist()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals('Awesome!', $this->request->server('WHAT_IS_FRESCO', 'Awesome!'));
    }

    function test_can_get_the_segments_of_the_current_request_path()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('/a/url/path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    function test_can_get_the_segments_of_the_current_request_path_without_leading_slash()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    function test_can_get_the_segments_of_the_current_request_path_with_trailing_slash()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/path/');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    function test_can_get_the_segments_of_the_current_request_path_with_zeroes_on_it()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertEquals(['a', 'url', '0', 'path'], $this->request->segments());
    }

    function test_can_get_the_segments_of_the_current_request_path_with_multiple_slashes()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url//path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    function test_will_get_an_empty_array_for_the_root_url()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('/');

        $this->assertEquals([], $this->request->segments());
    }

    function test_can_get_a_specific_segment_by_index()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertEquals('a', $this->request->segment(0));
        $this->assertEquals('url', $this->request->segment(1));
        $this->assertEquals('0', $this->request->segment(2));
        $this->assertEquals('path', $this->request->segment(3));
    }

    function test_can_get_a_default_null_value_for_an_inexistent_segment()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertNull($this->request->segment(6));
    }

    function test_can_set_a_default_value_to_get_for_an_inexistent_segment()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertEquals($segment = uniqid(), $this->request->segment(6, $segment));
    }
}
