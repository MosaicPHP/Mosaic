<?php

namespace Fresco\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Response as ResponseContract;
use Fresco\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Zend\Diactoros\Response\HtmlResponse;

class ResponseFactory implements ResponseFactoryContract
{
    /**
     * @param string $content
     * @param int    $status
     * @param array  $headers
     *
     * @return ResponseContract
     */
    public function html(string $content = null, int $status = 200, array $headers = []) : ResponseContract
    {
        $content = $content ?: '';

        return new Response(
            new HtmlResponse($content, $status, $headers)
        );
    }

    /**
     * @param mixed $content
     *
     * @param int   $status
     * @param array $headers
     *
     * @return ResponseContract
     */
    public function make($content = '', int $status = 200, array $headers = [])  : ResponseContract
    {
        return $this->html($content);
    }
}
