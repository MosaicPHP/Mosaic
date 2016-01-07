<?php

namespace Fresco\Contracts;

interface Application
{
    public function isLocal();

    /**
     * @param string $path
     *
     * @return string
     */
    public function storagePath($path = '') : string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function viewsPath() : string;
}
