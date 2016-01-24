<?php

namespace Fresco\Contracts\Exceptions;

use Throwable;

interface ExceptionRunner
{
    /**
     * @param string $formatter
     */
    public function setFormatter(string $formatter);

    /**
     * @param string $handler
     */
    public function addHandler(string $handler);

    /**
     * @param        $level
     * @param        $message
     * @param string $file
     * @param int    $line
     * @param array  $context
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = []);

    /**
     * @param \Throwable $e
     */
    public function handleException(Throwable $e);

    /**
     * Handle PHP shutdown event
     */
    public function handleShutdown();
}
