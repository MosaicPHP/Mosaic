<?php

namespace Fresco\Tests\Exceptions\Formatters;

use Exception;
use Fresco\Exceptions\Formatters\HtmlFormatter;

class HtmlFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HtmlFormatter
     */
    private $formatter;

    public function setUp()
    {
        $this->formatter = new HtmlFormatter();
    }

    public function test_it_renders_a_console_exception()
    {
        $this->formatter->render(new Exception('Exception message'));
    }
}
