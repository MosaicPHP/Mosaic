<?php

namespace Mosaic\Tests\Exceptions\Handlers;

use Exception;
use Mosaic\Exceptions\Handlers\LogHandler;

class LogHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogHandler
     */
    private $handler;

    public function setUp()
    {
        $this->handler = new LogHandler();
    }

    public function test_it_logs_the_exception()
    {
        $this->handler->handle(new Exception('Exception message'));
    }
}
