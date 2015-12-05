<?php

namespace Fresco\Contracts\Http;

use Psr\Http\Message\ResponseInterface;

interface Response extends ResponseInterface
{
    /**
     * Gets the response status code.
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function status();

    /**
     * Gets the body of the message.
     *
     * @return \Psr\Http\Message\StreamInterface Returns the body as a stream.
     */
    public function body();
}
