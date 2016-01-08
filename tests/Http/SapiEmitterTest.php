<?php

namespace Fresco\Tests\Http
{

    use Fresco\Contracts\Http\Response;
    use Fresco\Http\SapiEmitter;
    use Fresco\Tests\ClosesMockeryOnTearDown;
    use PHPUnit_Framework_TestCase;

    class SapiEmitterTest extends PHPUnit_Framework_TestCase
    {
        use ClosesMockeryOnTearDown;

        /**
         * @var \Mockery\Mock|null
         */
        public static $sapi;

        /**
         * @var bool
         */
        public static $headersSent = false;

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
            $this->emitter = new SapiEmitter();

            self::$sapi = \Mockery::mock(['header' => true, 'ob_get_level' => 1, 'ob_end_flush' => true]);
            $this->response = \Mockery::mock(Response::class);
        }

        public function test_it_emits_a_response_object_when_no_headers_were_sent()
        {
            self::$sapi->shouldReceive('header')->once()->with('HTTP/7.0 999 Just Because.');
            self::$sapi->shouldReceive('ob_end_flush')->never();
            self::$sapi->shouldReceive('ob_get_level')->twice();

            $this->response->shouldReceive('hasHeader')->with('Content-Length')->andReturn(true);
            $this->expectNormalOutputBehavior();

            $this->emitter->emit($this->response);
        }

        public function test_it_fails_hard_if_headers_were_sent()
        {
            $this->setExpectedException(\RuntimeException::class);
            self::$headersSent = true;

            $this->emitter->emit($this->response);
        }

        public function test_it_calculates_the_response_size_when_the_content_length_is_not_sent_and_size_is_available()
        {
            $this->response->shouldReceive('hasHeader')->with('Content-Length')->andReturn(false);
            $this->response->shouldReceive('size')->andReturn(1337);
            $this->response->shouldReceive('addHeader')->with('Content-Length', '1337')->once()->andReturnSelf();

            $this->expectNormalOutputBehavior();

            $this->emitter->emit($this->response);
        }

        protected function tearDown()
        {
            self::$sapi = null;
            self::$headersSent = false;

            parent::tearDown();
        }

        private function expectNormalOutputBehavior()
        {
            $this->response->shouldReceive('reason')->once()->andReturn('Just Because.');
            $this->response->shouldReceive('protocol')->once()->andReturn('7.0');
            $this->response->shouldReceive('status')->once()->andReturn(999);
            $this->response->shouldReceive('headers')->once()->andReturn([]);
            $this->response->shouldReceive('body')->once()->andReturn('The Body');

            $this->expectOutputString('The Body');
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
