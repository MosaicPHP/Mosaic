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
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        foreach ($this->getConfigFiles($app) as $key => $path) {
            $this->config->set($key, require $path);
        }

        $app->setEnvironment(
            $this->config->get('app.env', 'production')
        );

        date_default_timezone_set($this->config->get('app.timezone', 'UTC'));

        mb_internal_encoding('UTF-8');
    }

    /**
     * @param Application $app
     *
     * @return array
     */
    private function getConfigFiles(Application $app) : array
    {
        $files = [];

        $configPath = realpath($app->configPath());
        foreach (new RegexIterator(new DirectoryIterator($configPath), "/\\.php\$/i") as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }
}
