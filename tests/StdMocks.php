<?php

namespace Mosaic\Tests
{
    final class StdMocks
    {
        /**
         * @var \Mockery\Mock|null
         */
        public static $sapi;

        /**
         * @var bool
         */
        public static $headersSent = false;

        public static function setUp()
        {
            self::$sapi = \Mockery::mock(['header' => true, 'ob_get_level' => 1, 'ob_end_flush' => true, 'ob_start' => true]);

            /*
            self::$sapi->shouldReceive('ob_end_flush')->zeroOrMoreTimes()->andReturnUsing(function(){
                var_dump((new \Exception)->getTraceAsString());
                return true;
            });*/
        }

        public static function tearDown()
        {
            self::$sapi        = null;
            self::$headersSent = false;
        }
    }
}

namespace Mosaic\Http {

    use Mosaic\Tests\StdMocks;

    function headers_sent()
    {
        return StdMocks::$headersSent;
    }

    function header($string, $replace = true)
    {
        return StdMocks::$sapi ? StdMocks::$sapi->header($string, $replace) : \header($string, $replace);
    }

    function ob_get_level()
    {
        return StdMocks::$sapi ? StdMocks::$sapi->ob_get_level() : \ob_get_level();
    }

    function ob_end_flush()
    {
        return StdMocks::$sapi ? StdMocks::$sapi->ob_end_flush() : \ob_end_flush();
    }

    function ob_start()
    {
        return StdMocks::$sapi ? StdMocks::$sapi->ob_start() : \ob_start();
    }
}
