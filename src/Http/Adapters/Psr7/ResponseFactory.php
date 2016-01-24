<?php

namespace Fresco\Http\Adapters\Psr7;

use Fresco\Contracts\Http\Response as ResponseContract;
use Fresco\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Fresco\Contracts\Support\Arrayable;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

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
        if (!$content) {
            return $this->emptyResponse($status, $headers);
        }

        return new Response(
            new HtmlResponse($content, $status, $headers)
        );
    }

    /**
     * @param mixed $content
     * @param int   $status
     * @param array $headers
     *
     * @return ResponseContract
     */
    public function make($content = '', int $status = 200, array $headers = [])  : ResponseContract
    {
        if ($content instanceof ResponseContract) {
            return $content;
        }

        if (is_array($content) || $content instanceof Arrayable) {
            return $this->json($content, $status, $headers);
        }

        return $this->html((string)$content, $status, $headers);
    }

    /**
     * @param array|Arrayable $content
     * @param int             $status
     * @param array           $headers
     * @param int             $option
     *
     * @return ResponseContract
     */
    public function json($content = [], int $status = 200, array $headers = [], int $option = 79) : ResponseContract
    {
        if ($content instanceof Arrayable) {
            $content = $content->toArray();
        }

        return new Response(
            new JsonResponse($content, $status, $headers, $option)
        );
    }

    /**
     * @param $status
     * @param $headers
     *
     * @return ResponseContract
     */
    private function emptyResponse(int $status = 200, array $headers = []) : ResponseContract
    {
        return new Response(
            new EmptyResponse($status, $headers)
        );
    }
}
