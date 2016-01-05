<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
use Fresco\Contracts\Http\ResponseFactory;
use Throwable;

class HtmlFormatter implements ExceptionFormatter
{
    /**
     * @var ResponseFactory
     */
    protected $factory;

    /**
     * HtmlFormatter constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Throwable $e
     */
    public function render(Throwable $e)
    {
        echo $e->getMessage();
    }
}
