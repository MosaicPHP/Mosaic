<?php

namespace Fresco\Foundation\Bootstrap;

use DirectoryIterator;
use Fresco\Contracts\Application;
use Fresco\Contracts\Config\Config;
use RegexIterator;

class LoadConfiguration implements Bootstrapper
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Application
     */
    private $app;

    /**
     * LoadConfiguration constructor.
     *
     * @param Application $app
     * @param Config      $config
     */
    public function __construct(Application $app, Config $config)
    {
        $this->config = $config;
        $this->app    = $app;
    }

    /**
     * Bootstrap
     * @return mixed
     */
    public function bootstrap()
    {
        foreach ($this->getConfigFiles() as $key => $path) {
            $this->config->set($key, require $path);
        }
    }

    /**
     * @return array
     */
    private function getConfigFiles()
    {
        $files = [];

        $configPath = realpath($this->app->configPath());
        foreach (new RegexIterator(new DirectoryIterator($configPath), "/\\.php\$/i") as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }
}
