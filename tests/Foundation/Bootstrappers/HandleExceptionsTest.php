<?php

namespace Fresco\Tests\Foundation\Bootstrappers;

use Fresco\Application;
use Fresco\Foundation\Bootstrap\HandleExceptions;

class HandleExceptionsTest extends \PHPUnit_Framework_TestCase
{
    public $bootstrapper;

    public function setUp()
    {
        $this->bootstrapper = $bootstrapper = new HandleExceptions(new Runner(new Application(__DIR__)));
    }

    public function test_it_handles_exceptions()
    {
        $this->bootstrapper->bootstrap();

        $this->assertEquals('Off', ini_get('display_errors'));
        $this->assertEquals(-1, ini_get('error_reporting'));

        $errorHandler = set_error_handler(function () {
        });
        $this->assertEquals('handleError', $errorHandler[1]);

        $exceptionHandler = set_exception_handler(function () {
        });
        $this->assertEquals('handleException', $exceptionHandler[1]);
    }
}

class Runner extends \Fresco\Exceptions\Runner
{
}
