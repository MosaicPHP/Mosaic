<?php
namespace Fresco\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Psr7Request implements Request, RequestInterface
{
    /**
     * @var RequestInterface
     */
    private $wrapped;

    /**
     * Psr7Request constructor.
     *
     * @param RequestInterface $psr7Request
     */
    public function __construct(RequestInterface $psr7Request)
    {
        $this->wrapped = $psr7Request;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget()
    {
        return $this->wrapped->getRequestTarget();
    }

    /**
     * {@inheritdoc}
     */
    public function withRequestTarget($requestTarget)
    {
        return new static($this->wrapped->withRequestTarget($requestTarget));
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->wrapped->getMethod();
    }

    /**
     * {@inheritdoc}
     */
    public function withMethod($method)
    {
        return new static($this->wrapped->withMethod($method));
    }

    /**
     * {@inheritdoc}
     */
    public function getUri()
    {
        return $this->wrapped->getUri();
    }

    /**
     * {@inheritdoc}
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        return new static($this->wrapped->withUri($uri, $preserveHost));
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->wrapped->getProtocolVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        return new static($this->wrapped->withProtocolVersion($version));
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->wrapped->getHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return $this->wrapped->hasHeader($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        return $this->wrapped->getHeader($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        return $this->wrapped->getHeaderLine($name);
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        return new static($this->wrapped->withHeader($name, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        return new static($this->wrapped->withAddedHeader($name, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        return new static($this->wrapped->withoutHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->wrapped->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        return new static($this->wrapped->withBody($body));
    }

    /**
     * {@inheritdoc}
     */
    public function header($key = null, $default = null)
    {
        // TODO: Implement header() method.
    }

    /**
     * {@inheritdoc}
     */
    public function method()
    {
        // TODO: Implement method() method.
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        // TODO: Implement all() method.
    }

    /**
     * {@inheritdoc}
     */
    public function only($keys)
    {
        // TODO: Implement only() method.
    }

    /**
     * {@inheritdoc}
     */
    public function except($keys)
    {
        // TODO: Implement except() method.
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        // TODO: Implement exists() method.
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * {@inheritdoc}
     */
    public function server($key = null, $default = null)
    {
        // TODO: Implement server() method.
    }

    /**
     * {@inheritdoc}
     */
    public function segments()
    {
        // TODO: Implement segments() method.
    }

    /**
     * {@inheritdoc}
     */
    public function segment($index, $default = null)
    {
        // TODO: Implement segment() method.
    }

    /**
     * {@inheritdoc}
     */
    public function file($key = null, $default = null)
    {
        // TODO: Implement file() method.
    }

    /**
     * {@inheritdoc}
     */
    public function hasFile($key)
    {
        // TODO: Implement hasFile() method.
    }

    /**
     * {@inheritdoc}
     */
    public function cookies()
    {
        // TODO: Implement cookies() method.
    }

    /**
     * {@inheritdoc}
     */
    public function cookie($key = null, $default = null)
    {
        // TODO: Implement cookie() method.
    }
}
