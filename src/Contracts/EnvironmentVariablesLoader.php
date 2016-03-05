<?php

namespace Mosaic\Contracts;

interface EnvironmentVariablesLoader
{
    /**
     * @param string $filePath
     */
    public function load(string $filePath);

    /**
     * @return string
     */
    public function getFilename() : string;
}
