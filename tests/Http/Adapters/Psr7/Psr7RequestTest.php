<?php

namespace Fresco\Tests\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Request as RequestContract;
use Fresco\Http\Adapters\Psr7\Request;
use Fresco\Tests\ClosesMockeryOnTearDown;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Zend\Diactoros\Uri;

class Psr7RequestTest extends \PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ServerRequestInterface|\Mockery\MockInterface
     */
    private $wrappedMock;

    protected function setUp()
    {
        $this->request = new Request($this->wrappedMock = \Mockery::mock(ServerRequestInterface::class));
    }

    public function test_it_implements_the_fresco_request_interface()
    {
        $this->assertInstanceOf(RequestContract::class, $this->request);
    }

    public function test_it_implements_the_psr7_server_request_interface_for_internal_usage()
    {
        $this->assertInstanceOf(ServerRequestInterface::class, $this->request);
    }

    public function test_extract_an_existing_and_single_item_header_from_a_request_returns_the_item()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn(['text/html']);

        $this->assertEquals('text/html', $this->request->header('accept'));
    }

    public function test_extract_an_existing_and_multi_item_header_from_a_request_returns_all_the_items()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn(['text/html', 'text/plain']);

        $this->assertEquals(['text/html', 'text/plain'], $this->request->header('accept'));
    }

    public function test_extract_a_non_existing_header_from_a_request_returns_null()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn([]);

        $this->assertNull($this->request->header('accept'));
    }

    public function test_extract_a_non_existing_header_with_a_default_value_from_a_request_returns_the_default_value()
    {
        $this->wrappedMock->shouldReceive('getHeader')->with('accept')->once()->andReturn([]);

        $this->assertEquals('text/css', $this->request->header('accept', 'text/css'));
    }

    public function test_can_get_the_request_method()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn($method = uniqid());

        $this->assertEquals($method, $this->request->getMethod());
    }

    public function test_can_get_the_request_method_from_it()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn($method = uniqid());

        $this->assertEquals($method, $this->request->method());
    }

    public function test_can_get_the_request_uri()
    {
        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn('uri');

        $this->assertEquals('uri', $this->request->uri());
    }

    public function test_can_get_the_request_path()
    {
        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn(new Uri('path'));

        $this->assertEquals('path', $this->request->path());
    }

    public function test_can_get_protocol_version()
    {
        $this->wrappedMock->shouldReceive('getProtocolVersion')->once()->andReturn($version = uniqid());

        $this->assertEquals($version, $this->request->getProtocolVersion());
    }

    public function test_can_get_headers()
    {
        $this->wrappedMock->shouldReceive('getHeaders')->once()->andReturn(['test']);

        $this->assertEquals(['test'], $this->request->getHeaders());
    }

    public function test_can_get_header()
    {
        $this->wrappedMock->shouldReceive('getHeader')->once()->with('foo')->andReturn(['test']);

        $this->assertEquals(['test'], $this->request->getHeader('foo'));
    }

    public function test_can_get_request_target()
    {
        $this->wrappedMock->shouldReceive('getRequestTarget')->andReturn($this->request);

        $this->assertEquals($this->request, $this->request->getRequestTarget());
    }

    public function test_can_check_if_header_exists()
    {
        $this->wrappedMock->shouldReceive('hasHeader')->with('header')->andReturn(true);

        $this->assertTrue($this->request->hasHeader('header'));
    }

    public function test_can_get_header_line()
    {
        $this->wrappedMock->shouldReceive('getHeaderLine')->with('header')->andReturn('line');

        $this->assertEquals('line', $this->request->getHeaderLine('header'));
    }

    public function test_can_get_body()
    {
        $this->wrappedMock->shouldReceive('getBody')->andReturn('body');

        $this->assertEquals('body', $this->request->getBody());
    }

    public function test_can_get_cookie_params()
    {
        $this->wrappedMock->shouldReceive('getCookieParams')->andReturn(['name' => 'params']);

        $this->assertEquals(['name' => 'params'], $this->request->getCookieParams());
    }

    public function test_can_get_attributes()
    {
        $this->wrappedMock->shouldReceive('getAttributes')->andReturn('attributes');

        $this->assertEquals('attributes', $this->request->getAttributes());
    }

    public function test_can_get_attribute()
    {
        $this->wrappedMock->shouldReceive('getAttribute')->with('name', null)->andReturn('attribute');

        $this->assertEquals('attribute', $this->request->getAttribute('name'));
    }

    public function test_immutability_on_request_target()
    {
        $this->wrappedMock->shouldReceive('withRequestTarget')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withRequestTarget('foo'));
    }

    public function test_immutability_on_method()
    {
        $this->wrappedMock->shouldReceive('withMethod')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withMethod('POST'));
    }

    public function test_immutability_on_uri()
    {
        $this->wrappedMock->shouldReceive('withUri')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withUri(\Mockery::mock(UriInterface::class)));
    }

    public function test_immutability_on_protocol_version()
    {
        $this->wrappedMock->shouldReceive('withProtocolVersion')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withProtocolVersion('2.0'));
    }

    public function test_immutability_on_header()
    {
        $this->wrappedMock->shouldReceive('withHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withHeader('cache-control', 'max-age:0'));
    }

    public function test_immutability_on_added_header()
    {
        $this->wrappedMock->shouldReceive('withAddedHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withAddedHeader('cache-control', 'max-age:0'));
    }

    public function test_immutability_on_without_header()
    {
        $this->wrappedMock->shouldReceive('withoutHeader')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withoutHeader('cache-control'));
    }

    public function test_immutability_on_body()
    {
        $this->wrappedMock->shouldReceive('withBody')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withBody(\Mockery::mock(StreamInterface::class)));
    }

    public function test_immutability_on_cookie_params()
    {
        $this->wrappedMock->shouldReceive('withCookieParams')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withCookieParams(['cookie' => 'monster']));
    }

    public function test_immutability_on_query_params()
    {
        $this->wrappedMock->shouldReceive('withQueryParams')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withQueryParams(['q' => 'Fresco is awesome!']));
    }

    public function test_immutability_on_uploaded_files()
    {
        $this->wrappedMock->shouldReceive('withUploadedFiles')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withUploadedFiles(['logo.png' => 'FrescoLogo']));
    }

    public function test_immutability_on_parsed_body()
    {
        $this->wrappedMock->shouldReceive('withParsedBody')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withParsedBody(['some' => 'parsed data']));
    }

    public function test_immutability_on_attribute()
    {
        $this->wrappedMock->shouldReceive('withAttribute')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withAttribute('some', 'attribute'));
    }

    public function test_immutability_on_without_attribute()
    {
        $this->wrappedMock->shouldReceive('withoutAttribute')->andReturn(\Mockery::mock(ServerRequestInterface::class));

        $this->assertNotEquals($this->request, $this->request->withoutAttribute('some'));
    }

    public function test_can_get_request_parameters_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertEquals('bar', $this->request->get('foo'));
    }

    public function test_can_get_a_default_null_value_from_a_non_existing_request_parameter_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertNull($this->request->get('baz'));
    }

    public function test_can_get_a_given_default_value_from_a_non_existing_request_parameter_out_of_a_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->andReturn(['foo' => 'bar']);
        $this->wrappedMock->shouldReceive('getParsedBody')->never();

        $this->assertEquals($default = uniqid(), $this->request->get('baz', $default));
    }

    public function test_can_get_request_parameters_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertEquals('bar', $this->request->get('foo'));
    }

    public function test_can_get_a_default_null_value_from_a_non_existing_request_parameter_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertNull($this->request->get('baz'));
    }

    public function test_can_get_a_given_default_value_from_a_non_existing_request_parameter_out_of_a_non_get_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo' => 'bar'
        ]);

        $this->assertEquals($default = uniqid(), $this->request->get('baz', $default));
    }

    public function test_on_non_get_requests_query_parameters_have_precedence_over_body_parameters()
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

    public function test_can_obtain_all_get_parameters()
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

    public function test_can_obtain_all_post_parameters()
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

    public function test_can_obtain_all_post_parameters_with_merged_ones_from_query()
    {
        $this->wrappedMock->shouldReceive('getMethod')->once()->andReturn('POST');
        $this->wrappedMock->shouldReceive('getQueryParams')->once()->andReturn([
            'foo' => 'baz',
            'bar' => 'foo',
        ]);
        $this->wrappedMock->shouldReceive('getParsedBody')->once()->andReturn([
            'foo'    => 'baz',
            'barbaz' => 'foobar'
        ]);

        $this->assertEquals([
            'foo'    => 'baz',
            'bar'    => 'foo',
            'barbaz' => 'foobar'
        ], $this->request->all());
    }

    public function test_can_obtain_only_some_parameters_from_the_request()
    {
        $this->wrappedMock->shouldReceive('getMethod')->twice()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->twice()->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'baz' => 'fo'], $this->request->only(['foo', 'baz']));
    }

    public function test_can_obtain_only_one_parameter_from_the_request()
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

    public function test_when_obtaining_only_some_parameters_from_the_request_they_are_returned_back_as_null_if_they_dont_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(
            [
                'foo'        => 'bar',
                'baz'        => 'fo',
                'idontexist' => null
            ],
            $this->request->only(['foo', 'baz', 'idontexist'])
        );
    }

    public function test_can_obtain_all_parameters_except_a_given_set()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $this->request->except(['baz', 'bez']));
    }

    public function test_can_obtain_all_parameters_except_a_given_one()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(4)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(4)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo', 'bez' => 'fe'], $this->request->except('baz'));
    }

    public function test_can_check_if_a_parameter_exists()
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

    public function test_can_check_if_a_parameter_doesnt_exist()
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

    public function test_can_check_if_a_set_of_parameters_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->exists(['foo', 'bar', 'baz']));
    }

    public function test_can_check_if_a_set_of_parameters_dont_exist()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->exists(['foo', 'bar', 'bag']));
    }

    public function test_can_check_if_it_has_a_non_empty_parameter()
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

    public function test_can_check_if_it_doesnt_have_a_non_empty_parameter()
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

    public function test_can_check_if_it_has_a_non_empty_set_of_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => 'fo',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    public function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => '',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->has(['foo', 'bar', 'baz']));
    }

    public function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_zero_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => 'foo',
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    public function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_array_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->times(3)->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->times(3)->andReturn([
            'foo' => 'bar',
            'bar' => ['foo', 'bar'],
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertTrue($this->request->has(['foo', 'bar', 'baz']));
    }

    public function test_can_check_if_it_doesnt_have_a_non_empty_set_of_parameters_including_a_possible_empty_array_parameter()
    {
        $this->wrappedMock->shouldReceive('getMethod')->twice()->andReturn('GET');
        $this->wrappedMock->shouldReceive('getQueryParams')->twice()->andReturn([
            'foo' => 'bar',
            'bar' => [],
            'baz' => '0',
            'bez' => 'fe'
        ]);

        $this->assertFalse($this->request->has(['foo', 'bar', 'baz']));
    }

    public function test_can_get_server_params()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->twice()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ], $this->request->server());

        $this->assertEquals([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ], $this->request->getServerParams());
    }

    public function test_can_get_a_specific_server_param()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals('/i/am/g/root', $this->request->server('DOCUMENT_ROOT'));
    }

    public function test_will_get_null_as_default_if_a_specific_server_param_does_not_exist()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertNull($this->request->server('APP_ENGINE'));
    }

    public function test_can_use_a_default_value_if_a_specific_server_param_does_not_exist()
    {
        $this->wrappedMock->shouldReceive('getServerParams')->once()->andReturn([
            'DOCUMENT_ROOT' => '/i/am/g/root'
        ]);

        $this->assertEquals('Awesome!', $this->request->server('WHAT_IS_FRESCO', 'Awesome!'));
    }

    public function test_can_get_the_segments_of_the_current_request_path()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('/a/url/path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    public function test_can_get_the_segments_of_the_current_request_path_without_leading_slash()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    public function test_can_get_the_segments_of_the_current_request_path_with_trailing_slash()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/path/');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    public function test_can_get_the_segments_of_the_current_request_path_with_zeroes_on_it()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertEquals(['a', 'url', '0', 'path'], $this->request->segments());
    }

    public function test_can_get_the_segments_of_the_current_request_path_with_multiple_slashes()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url//path');

        $this->assertEquals(['a', 'url', 'path'], $this->request->segments());
    }

    public function test_will_get_an_empty_array_for_the_root_url()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('/');

        $this->assertEquals([], $this->request->segments());
    }

    public function test_can_get_a_specific_segment_by_index()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->times(4)->andReturn($uri);
        $uri->shouldReceive('getPath')->times(4)->andReturn('a/url/0/path');

        $this->assertEquals('a', $this->request->segment(0));
        $this->assertEquals('url', $this->request->segment(1));
        $this->assertEquals('0', $this->request->segment(2));
        $this->assertEquals('path', $this->request->segment(3));
    }

    public function test_can_get_a_default_null_value_for_an_inexistent_segment()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertNull($this->request->segment(6));
    }

    public function test_can_set_a_default_value_to_get_for_an_inexistent_segment()
    {
        /** @var UriInterface|\Mockery\MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        $this->wrappedMock->shouldReceive('getUri')->once()->andReturn($uri);
        $uri->shouldReceive('getPath')->once()->andReturn('a/url/0/path');

        $this->assertEquals($segment = uniqid(), $this->request->segment(6, $segment));
    }

    public function test_can_get_a_file_descriptor_out_of_the_request()
    {
        $avatar = ['file' => 'avatar.jpg', 'path' => '/some/path'];

        $this->wrappedMock->shouldReceive('getUploadedFiles')->once()->andReturn([
            'avatar' => $avatar
        ]);

        $this->assertEquals($avatar, $this->request->file('avatar'));
    }

    public function test_will_get_a_default_null_value_if_a_file_is_not_on_the_request()
    {
        $avatar = ['file' => 'avatar.jpg', 'path' => '/some/path'];

        $this->wrappedMock->shouldReceive('getUploadedFiles')->once()->andReturn([
            'avatar' => $avatar
        ]);

        $this->assertNull($this->request->file('profile_picture'));
    }

    public function test_can_get_a_given_default_value_if_a_file_descriptor_is_not_on_the_request()
    {
        $avatar = ['file' => 'avatar.jpg', 'path' => '/some/path'];

        $this->wrappedMock->shouldReceive('getUploadedFiles')->once()->andReturn([
            'avatar' => $avatar
        ]);

        $this->assertEquals('Default stuff', $this->request->file('noop', 'Default stuff'));
    }

    public function test_can_check_if_it_has_a_given_file_by_name()
    {
        $avatar = ['file' => 'avatar.jpg', 'path' => '/some/path'];

        $this->wrappedMock->shouldReceive('getUploadedFiles')->once()->andReturn([
            'avatar' => $avatar
        ]);

        $this->assertTrue($this->request->hasFile('avatar'));
    }

    public function test_can_get_cookies()
    {
        $this->wrappedMock->shouldReceive('getCookieParams')->andReturn(['name' => 'params']);

        $this->assertEquals(['name' => 'params'], $this->request->cookies());
    }

    public function test_can_get_a_single_cookie_by_key()
    {
        $this->wrappedMock->shouldReceive('getCookieParams')->andReturn(['name' => 'params']);

        $this->assertEquals('params', $this->request->cookie('name'));
    }

    public function test_can_get_a_default_value_when_no_cookie_is_found_by_key()
    {
        $this->wrappedMock->shouldReceive('getCookieParams')->andReturn(['name' => 'params']);

        $this->assertEquals('default', $this->request->cookie('missing', 'default'));
    }
}
