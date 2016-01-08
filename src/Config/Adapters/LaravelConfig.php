<?php

namespace Fresco\Config\Adapters;

use Fresco\Contracts\Config\Config;
use Illuminate\Config\Repository;

class LaravelConfig implements Config
{
    /**
     * @var Repository
     */
    private $delegate;

    /**
     * LaravelConfig constructor.
     *
     * @param Repository $delegate
     */
    public function __construct(Repository $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key) : bool
    {
        return $this->delegate->has($key);
    }

    /**
     * Get the specified configuration value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->delegate->get($key, $default);
    }

    /**
     * Get all of the configuration items for the application.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->delegate->all();
    }

    /**
     * Set a given configuration value.
     *
     * @param array|string $key
     * @param mixed        $value
     *
     * @return void
     */
    public function set($key, $value = null)
    {
        $this->delegate->set($key, $value);
    }
}
