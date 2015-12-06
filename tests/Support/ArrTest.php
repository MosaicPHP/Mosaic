<?php
namespace Fresco\Tests\Support;

use Fresco\Support\Arr;
use PHPUnit_Framework_TestCase;

class ArrTest extends PHPUnit_Framework_TestCase
{
    function test_getting_a_value_from_an_array_by_key()
    {
        $this->assertEquals('bar', Arr::get(['foo' => 'bar'], 'foo'));
    }

    function test_getting_a_default_value_from_an_array_when_key_doesnt_exist()
    {
        $this->assertEquals('barbaz', Arr::get(['foo' => 'bar'], 'baz', 'barbaz'));
    }
}
