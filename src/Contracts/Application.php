<?php

namespace Fresco\Contracts;

use Fresco\Contracts\Exceptions\ExceptionRunner;

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

    /**
     * @param ExceptionRunner $runner
     */
    public function setExceptionRunner(ExceptionRunner $runner);

    /**
     * @return ExceptionRunner
     */
    public function getExceptionRunner() : ExceptionRunner;
}
