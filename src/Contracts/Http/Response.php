<?php

namespace Fresco\Contracts\Http;

/**
 * @TODO: Installed version of mockery doesn't seem to allow mocking classes with return type hinting
 */
interface Response
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
     * @return string Returns the body as string.
     */
    public function body();

    /**
     * @return int|null
     */
    public function size();

    /**
     * @param string $string
     * @param string $param
     *
     * @return static
     */
    public function addHeader(string $header, string $value);

    /**
     * @param string $string
     *
     * @return bool
     */
    public function hasHeader(string $header);

    /**
     * @return string
     */
    public function reason();

    /**
     * @return string
     */
    public function protocol();

    /**
     * @return array
     */
    public function headers();
}
