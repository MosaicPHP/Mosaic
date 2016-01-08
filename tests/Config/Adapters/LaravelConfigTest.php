<?php

namespace Fresco\Tests\Config\Adapters;

use Fresco\Config\Adapters\LaravelConfig;
use Illuminate\Config\Repository;
use Mockery\Mock;

class LaravelConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LaravelConfig
     */
    private $config;

    /**
     * @var Mock
     */
    private $repository;

    public function setUp()
    {
        $this->repository = \Mockery::mock(Repository::class);
        $this->config     = new LaravelConfig($this->repository);
    }

    public function test_can_check_if_config_key_exists()
    {
        $this->repository->shouldReceive('has')->with('key')->once()->andReturn(true);

        $this->assertTrue($this->config->has('key'));
    }

    public function test_can_get_config_value()
    {
        $this->repository->shouldReceive('get')->with('key', null)->once()->andReturn('value');

        $this->assertEquals('value', $this->config->get('key'));
    }

    public function test_can_get_config_value_with_default_value_as_fallback()
    {
        $this->repository->shouldReceive('get')->with('key', 'default')->once()->andReturn('value');

        $this->assertEquals('value', $this->config->get('key', 'default'));
    }

    public function test_can_get_dot_notated_config()
    {
        $this->repository->shouldReceive('get')->with('app.key', null)->once()->andReturn('value');

        $this->assertEquals('value', $this->config->get('app.key', null));
    }

    public function test_can_get_all_config()
    {
        $this->repository->shouldReceive('all')->once()->andReturn(['some' => 'value']);

        $this->assertEquals(['some' => 'value'], $this->config->all());
    }

    public function test_can_set_config_value()
    {
        $this->repository->shouldReceive('set')->with('key', 'value')->once();

        $this->config->set('key', 'value');
    }

    public function test_can_set_array_of_config_values()
    {
        $this->repository->shouldReceive('set')->with(['key' => 'value'], null)->once();

        $this->config->set(['key' => 'value']);
    }
}
