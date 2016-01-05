<?php

namespace Fresco\Contracts\Http;

interface ResponseFactory
{
    /**
     * @param string $content
     * @param int    $status
     * @param array  $headers
     *
     * @return Response
     */
    public function html(string $content = null, int $status = 200, array $headers = []) : Response;

    /**
     * @param mixed $content
     *
     * @param int   $status
     * @param array $headers
     *
     * @return Response
     */
    public function make($content = '', int $status = 200, array $headers = [])  : Response;
}
