<?php

namespace Fresco\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Response as ResponseContract;
use Psr\Http\Message\ResponseInterface;

class Response implements ResponseContract
{

    /**
     * @var ServerRequestInterface
     */
    private $wrapped;

    /**
     * @param ResponseInterface $wrapper
     */
    public function __construct(ResponseInterface $wrapper)
    {
        $this->wrapped = $wrapper;
    }

    /**
     * Gets the response status code.
     * The status code is a 3-digit integer result code of the server's attempt
     * to understand and satisfy the request.
     *
     * @return int Status code.
     */
    public function status() : int
    {
        return $this->wrapped->getStatusCode();
    }

    /**
     * Gets the body of the message.
     *
     * @return string Returns the body as string.
     */
    public function body() : string
    {
        return (string) $this->wrapped->getBody();
    }

    /**
     * @return int|null
     */
    public function size()
    {
        return $this->wrapped->getBody()->getSize();
    }

    /**
     * @param string $string
     * @param string $param
     *
     * @return static
     */
    public function addHeader(string $header, string $value) : ResponseContract
    {
        return new static($this->wrapped->withHeader($header, $value));
    }

    /**
     *
     * @param string $string
     *
     * @return bool
     */
    public function hasHeader(string $header) : bool
    {
        return $this->wrapped->hasHeader($header);
    }

    /**
     * @return string
     */
    public function reason() : string
    {
        return $this->wrapped->getReasonPhrase();
    }

    /**
     * @return string
     */
    public function protocol() : string
    {
        return $this->wrapped->getProtocolVersion();
    }

    /**
     * @return array
     */
    public function headers() : array
    {
        return $this->wrapped->getHeaders();
    }
}
