<?php

namespace Mosaic\Foundation\EnvironmentVariables\Adapters;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Mosaic\Contracts\EnvironmentVariablesLoader;

class DotEnvVariableLoader implements EnvironmentVariablesLoader
{
    /**
     * @param string $path
     */
    public function load(string $path)
    {
        try {
            (new Dotenv($path, $this->getFilename()))->load();
        } catch (InvalidPathException $e) {
            //
        }
    }

    /**
     * @return string
     */
    public function getFilename() : string
    {
        return '.env';
    }
}
