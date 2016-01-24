<?php

namespace Fresco\Support;

use Fresco\Contracts\Support\Arrayable;

class ArrayObject implements Arrayable
{
    /**
     * @var array
     */
    private $data;

    /**
     * ArrayObject constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}
