<?php

namespace Mosaic\Contracts;

use Mosaic\Contracts\Container\Container;
use Mosaic\Contracts\Exceptions\ExceptionRunner;

interface Application
{
    /**
     * Application root path
     *
     * @param string $path
     *
     * @return string
     */
    public function path(string $path = '') : string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function configPath(string $path = '') : string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function storagePath(string $path = '') : string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function viewsPath(string $path = '') : string;

    /**
     * @param string[] $definitions
     */
    public function definitions(array $definitions);

    /**
     * Bootstrap the Application
     */
    public function bootstrap();

    /**
     * @param ExceptionRunner $runner
     */
    public function setExceptionRunner(ExceptionRunner $runner);

    /**
     * @return ExceptionRunner
     */
    public function getExceptionRunner() : ExceptionRunner;

    /**
     * @return string
     */
    public function env() : string;

    /**
     * @return bool
     */
    public function isLocal() : bool;

    /**
     * @param string $env
     */
    public function setEnvironment(string $env);

    /**
     * @param string $context
     */
    public function setContext(string $context);

    /**
     * @return string
     */
    public function getContext() : string;

    /**
     * @return Container
     */
    public function getContainer() : Container;
}
