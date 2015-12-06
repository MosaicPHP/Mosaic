<?php

namespace Fresco\Contracts\Http;

interface Request
{
    /**
     * Retrieve a header from the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return string|array
     */
    public function header($key = null, $default = null);

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method();

    /**
     * Gets a "parameter" value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function all();

    /**
     * Get a subset of the items from the input data.
     *
     * @param array $keys
     *
     * @return array
     */
    public function only($keys);

    /**
     * Get all of the input except for a specified array of items.
     *
     * @param array|mixed $keys
     *
     * @return array
     */
    public function except($keys);

    /**
     * Determine if the request contains a given input item key.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function exists($key);

    /**
     * Determine if the request contains a non-empty value for an input item.
     *
     * @param string|array $key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Retrieve a server variable from the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return string|array
     */
    public function server($key = null, $default = null);

    /**
     * Get all of the segments for the request path.
     *
     * @return string[]
     */
    public function segments();

    /**
     * Get a segment from the URI.
     *
     * @param  int         $index
     * @param  string|null $default
     *
     * @return string|null
     */
    public function segment($index, $default = null);

    /**
     * Retrieve a file from the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return array
     */
    public function file($key = null, $default = null);

    /**
     * Determine if the uploaded data contains a file.
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasFile($key);

    /**
     * Retrieve cookies from request
     *
     * @return
     */
    public function cookies();

    /**
     * Retrieve a cookie from the request.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return string|array
     */
    public function cookie($key = null, $default = null);
}
