<?php

namespace Mosaic\Contracts\Http;

interface Server
{
    /**
     * Listen to a server request
     *
     * @param callable $terminate
     */
    public function listen(callable $terminate = null);

    /**
     * @return string
     */
    public function getName() : string;
}
