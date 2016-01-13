<?php

namespace Fresco\Tests\Exceptions\Formatters;

use Exception;
use Fresco\Exceptions\Formatters\ConsoleFormatter;

class ConsoleFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsoleFormatter
     */
    private $formatter;

    public function setUp()
    {
        $this->formatter = new ConsoleFormatter();
    }

    public function test_it_renders_a_console_exception()
    {
        $this->formatter->render(new Exception('Exception message'));
    }
}
