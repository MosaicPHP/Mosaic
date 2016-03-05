<?php

namespace Mosaic\Tests\Exceptions\Formatters;

use Exception;
use Mosaic\Exceptions\Formatters\JsonFormatter;

class JsonFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonFormatter
     */
    private $formatter;

    public function setUp()
    {
        $this->formatter = new JsonFormatter();
    }

    public function test_it_renders_a_console_exception()
    {
        $this->formatter->render(new Exception('Exception message'));
    }
}
