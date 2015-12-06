<?php

namespace Fresco\Contracts\Http;

interface Server
{
    /**
     * Listen to a server request
     *
     * @param Request  $request
     * @param callable $terminate
     */
    public function listen(Request $request, callable $terminate = null);
}
