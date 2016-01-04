<?php

namespace Fresco\Contracts\Http;

interface Response
{
    /**
     * Gets the response status code.
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function status() : int;

    /**
     * Gets the body of the message.
     *
     * @return string Returns the body as string.
     */
    public function body() : string;
}
