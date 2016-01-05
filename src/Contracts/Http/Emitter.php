<?php

namespace Fresco\Contracts\Http;

interface Emitter
{
    /**
     * @param Response $response
     * @param null     $maxBufferLevel
     */
    public function emit(Response $response, $maxBufferLevel = null);
}
