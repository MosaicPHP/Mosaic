<?php

namespace Mosaic\Tests\Support;

use Mosaic\Support\Arr;
use PHPUnit_Framework_TestCase;

class ArrTest extends PHPUnit_Framework_TestCase
{
    public function test_getting_a_value_from_an_array_by_key()
    {
        $this->assertEquals('bar', Arr::get(['foo' => 'bar'], 'foo'));
    }

    public function test_getting_a_default_value_from_an_array_when_key_doesnt_exist()
    {
        $this->assertEquals('barbaz', Arr::get(['foo' => 'bar'], 'baz', 'barbaz'));
    }

    public function test_it_unwraps_a_single_item_array_to_the_item()
    {
        $this->assertEquals('foo', Arr::unwrap(['foo']));
    }

    public function test_it_returns_the_array_as_is_when_more_than_a_single_items_exist()
    {
        $input = ['foo', 'bar'];

        $this->assertEquals($input, Arr::unwrap($input));
    }

    public function test_it_returns_a_default_value_for_empty_arrays()
    {
        $this->assertEquals('bar', Arr::unwrap([], 'bar'));
    }
}
