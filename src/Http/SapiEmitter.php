<?php

namespace Fresco\Http;

use Fresco\Contracts\Http\Emitter;
use Fresco\Contracts\Http\Response;
use RuntimeException;

class SapiEmitter implements Emitter
{
    /**
     * @param Response $response
     * @param null     $maxBufferLevel
     *
     * @throws RuntimeException
     */
    public function emit(Response $response, $maxBufferLevel = null)
    {
        if (headers_sent()) {
            throw new RuntimeException('Unable to emit response. Headers were already sent');
        }

        if (!$response->hasHeader('Content-Length')) {
            // PSR-7 indicates int OR null for the stream size; for null values,
            // we will not auto-inject the Content-Length.
            if (null !== $response->size()) {
                $response = $response->addHeader('Content-Length', (string)$response->size());
            }
        }

        $this->emitStatus($response);
        $this->emitHeaders($response);
        $this->emitBody($response, $maxBufferLevel);
    }

    /**
     * @param Response $response
     */
    private function emitStatus(Response $response)
    {
        $reasonPhrase = $response->reason();

        header(sprintf(
            'HTTP/%s %d%s',
            $response->protocol(),
            $response->status(),
            ($reasonPhrase ? ' ' . $reasonPhrase : '')
        ));
    }

    /**
     * @param Response $response
     */
    private function emitHeaders(Response $response)
    {
        foreach ($response->headers() as $header => $values) {
            $name  = $this->filterHeader($header);
            $first = true;
            foreach ($values as $value) {
                header(sprintf(
                    '%s: %s',
                    $name,
                    $value
                ), $first);
                $first = false;
            }
        }
    }

    /**
     * @param Response $response
     * @param          $maxBufferLevel
     */
    private function emitBody(Response $response, $maxBufferLevel)
    {
        if (null === $maxBufferLevel) {
            $maxBufferLevel = ob_get_level();
        }

        while (ob_get_level() > $maxBufferLevel) {
            ob_end_flush();
        }

        echo $response->body();
    }

    /**
     * Filter a header name to wordcase
     *
     * @param string $header
     *
     * @return string
     */
    private function filterHeader($header)
    {
        $filtered = str_replace('-', ' ', $header);
        $filtered = ucwords($filtered);

        return str_replace(' ', '-', $filtered);
    }
}
