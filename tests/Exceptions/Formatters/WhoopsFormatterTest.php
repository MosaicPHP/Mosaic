<?php

namespace Fresco\Tests\Exceptions\Formatters;

use Exception;
use Fresco\Exceptions\Formatters\ConsoleFormatter;
use Fresco\Exceptions\Formatters\WhoopsFormatter;
use Mockery\Mock;
use Whoops\Run;
use Whoops\Util\SystemFacade;

class WhoopsFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mock
     */
    private $system;

    /**
     * @var ConsoleFormatter
     */
    private $formatter;

    public function setUp()
    {
        $this->system    = \Mockery::mock(SystemFacade::class);
        $this->formatter = new WhoopsFormatter(
            new Run()
        );
    }

    public function test_it_renders_a_console_exception()
    {
        $this->formatter->render(new Exception('Exception message'));
    }
}
