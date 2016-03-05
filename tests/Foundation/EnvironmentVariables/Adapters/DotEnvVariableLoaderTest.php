<?php

namespace Mosaic\Tests\Foundation\EnvironmentVariables\Adapters;

use Mosaic\Foundation\EnvironmentVariables\Adapters\DotEnvVariableLoader;
use PHPUnit_Framework_TestCase;

class DotEnvVariableLoaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DotEnvVariableLoader
     */
    private $loader;

    public function setUp()
    {
        $this->loader = new DotEnvVariableLoader();
    }

    public function test_can_load_env_file()
    {
        $this->loader->load(__DIR__ . '/../../../fixtures');

        $this->assertEquals('env_value', getenv('SOME_ENV'));
    }

    public function test_invalid_path_exceptions_get_ignored()
    {
        $this->loader->load(__DIR__ . '/false');
    }

    public function test_can_get_filename()
    {
        $this->assertEquals('.env', $this->loader->getFilename());
    }
}
