<?php

namespace Mosaic\Tests\Http;

use Mosaic\Contracts\Http\Response;
use Mosaic\Http\SapiEmitter;
use Mosaic\Tests\ClosesMockeryOnTearDown;
use Mosaic\Tests\MocksTheStandardLibrary;
use Mosaic\Tests\StdMocks;
use PHPUnit_Framework_TestCase;

class SapiEmitterTest extends PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;
    use MocksTheStandardLibrary;

    /**
     * @var SapiEmitter
     */
    private $emitter;

    /**
     * @var \Mockery\Mock
     */
    private $response;

    protected function setUp()
    {
        $this->emitter  = new SapiEmitter();
        $this->response = \Mockery::mock(Response::class);
    }

    public function test_it_emits_a_response_object_when_no_headers_were_sent()
    {
        StdMocks::$sapi->shouldReceive('ob_end_flush')->never();
        StdMocks::$sapi->shouldReceive('ob_get_level')->twice();

        $this
            ->withContentLength()
            ->withStatus()
            ->withoutHeaders()
            ->withBody();

        $this->emitter->emit($this->response);
    }

    public function test_it_fails_hard_if_headers_were_sent()
    {
        $this->setExpectedException(\RuntimeException::class);
        StdMocks::$headersSent = true;

        $this->emitter->emit($this->response);
    }

    public function test_it_calculates_the_response_size_when_the_content_length_is_not_sent_and_size_is_available()
    {
        $this
            ->withoutContentLength()
            ->withSize()
            ->withoutHeaders()
            ->withBody()
            ->withStatus();

        $this->emitter->emit($this->response);
    }

    public function test_it_doesnt_set_the_response_size_when_the_content_length_is_not_sent_and_size_is_not_available()
    {
        $this
            ->withoutContentLength()
            ->withoutSize()
            ->withoutHeaders()
            ->withBody()
            ->withStatus();

        $this->emitter->emit($this->response);
    }

    public function test_it_emits_all_headers()
    {
        $this
            ->withContentLength()
            ->withStatus()
            ->withHeaders()
            ->withBody();

        $this->emitter->emit($this->response);
    }

    public function test_it_considers_the_max_buffer_level()
    {
        StdMocks::$sapi->shouldReceive('ob_end_flush')->once();
        StdMocks::$sapi->shouldReceive('ob_get_level')->times(2)->andReturnValues([4, 3]);

        $this
            ->withContentLength()
            ->withStatus()
            ->withoutHeaders()
            ->withBody();

        $this->emitter->emit($this->response, 3);
    }

    public function test_it_shouldnt_end_buffer_if_its_level_is_below_the_given_max()
    {
        StdMocks::$sapi->shouldReceive('ob_end_flush')->never();
        StdMocks::$sapi->shouldReceive('ob_get_level')->once()->andReturnValues([2]);

        $this
            ->withContentLength()
            ->withStatus()
            ->withoutHeaders()
            ->withBody();

        $this->emitter->emit($this->response, 3);
    }

    /**
     * @return $this
     */
    private function withStatus()
    {
        StdMocks::$sapi->shouldReceive('header')->with('HTTP/7.0 999 Just Because.', true)->once();

        $this->response->shouldReceive('reason')->once()->andReturn('Just Because.');
        $this->response->shouldReceive('protocol')->once()->andReturn('7.0');
        $this->response->shouldReceive('status')->once()->andReturn(999);

        return $this;
    }

    /**
     * @return $this
     */
    private function withContentLength()
    {
        $this->response->shouldReceive('hasHeader')->with('Content-Length')->andReturn(true);

        return $this;
    }

    /**
     * @return $this
     */
    private function withoutContentLength()
    {
        $this->response->shouldReceive('hasHeader')->with('Content-Length')->andReturn(false);

        return $this;
    }

    /**
     * @param int $size
     *
     * @return $this
     */
    private function withSize($size = 1337)
    {
        $this->response->shouldReceive('size')->andReturn($size);
        $this->response->shouldReceive('addHeader')->with('Content-Length', (string) $size)->once()->andReturnSelf();

        return $this;
    }

    /**
     * @return $this
     */
    private function withoutSize()
    {
        $this->response->shouldReceive('size')->andReturnNull();
        $this->response->shouldReceive('addHeader')->with('Content-Length', \Mockery::any())->never();

        return $this;
    }

    /**
     * @return $this
     */
    private function withoutHeaders()
    {
        $this->response->shouldReceive('headers')->once()->andReturn([]);

        return $this;
    }

    /**
     * @return $this
     */
    private function withHeaders()
    {
        $this->response->shouldReceive('headers')->once()->andReturn([
            'content-type' => ['application/awesome'],
            'accept'       => ['the-truth', 'is-a-band'],
        ]);

        StdMocks::$sapi->shouldReceive('header')->with('Content-Type: application/awesome', true)->once();
        StdMocks::$sapi->shouldReceive('header')->with('Accept: the-truth', true)->once();
        StdMocks::$sapi->shouldReceive('header')->with('Accept: is-a-band', false)->once();

        return $this;
    }

    /**
     * @param string $body
     *
     * @return $this
     */
    private function withBody($body = 'The Body')
    {
        $this->response->shouldReceive('body')->once()->andReturn($body);
        $this->expectOutputString($body);

        return $this;
    }
}
