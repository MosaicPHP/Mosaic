<?php

namespace Fresco\Tests\Http
{

    use Fresco\Contracts\Http\Response;
    use Fresco\Http\SapiEmitter;
    use PHPUnit_Framework_TestCase;

    class SapiEmitterTest extends PHPUnit_Framework_TestCase
    {
        public static $sapi;
        public static $headersSent = false;

        public function test_it_emits_a_response_object_when_no_headers_were_sent()
        {
            $sapiEmitter = new SapiEmitter();

            self::$sapi = \Mockery::mock(['header' => true, 'ob_get_level' => 1, 'ob_end_flush' => true]);
            self::$sapi->shouldReceive('header')->once()->with('HTTP/7.0 999 Just Because.');
            self::$sapi->shouldReceive('ob_end_flush')->never();
            self::$sapi->shouldReceive('ob_get_level')->twice();

            $response = \Mockery::mock(Response::class);
            $response->shouldReceive('hasHeader')->with('Content-Length')->andReturn(true);
            $response->shouldReceive('reason')->once()->andReturn('Just Because.');
            $response->shouldReceive('protocol')->once()->andReturn('7.0');
            $response->shouldReceive('status')->once()->andReturn(999);
            $response->shouldReceive('headers')->once()->andReturn([]);
            $response->shouldReceive('body')->once()->andReturn('The Body');

            $this->expectOutputString('The Body');
            $sapiEmitter->emit($response);
        }

        protected function tearDown()
        {
            \Mockery::close();
            self::$sapi = null;

            parent::tearDown();
        }
    }
}

namespace Fresco\Http {

    use Fresco\Tests\Http\SapiEmitterTest;

    function headers_sent()
    {
        return SapiEmitterTest::$headersSent;
    }

    function header($message)
    {
        return SapiEmitterTest::$sapi ? SapiEmitterTest::$sapi->header($message) : \header($message);
    }

    function ob_get_level()
    {
        return SapiEmitterTest::$sapi ? SapiEmitterTest::$sapi->ob_get_level() : \ob_get_level();
    }

    function ob_end_flush()
    {
        return SapiEmitterTest::$sapi ? SapiEmitterTest::$sapi->ob_end_flush() : \ob_end_flush();
    }
}
