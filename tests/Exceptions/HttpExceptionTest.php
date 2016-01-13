<?php

namespace Fresco\Tests\Exceptions;

use Fresco\Exceptions\HttpException;
use PHPUnit_Framework_TestCase;

class HttpExceptionTest extends PHPUnit_Framework_TestCase
{
    public function test_it_holds_on_to_a_status_code()
    {
        $e = new HttpException("Whoops!", 503);

        $this->assertEquals(503, $e->getStatusCode());
    }
}
