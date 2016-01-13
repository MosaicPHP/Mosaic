<?php

namespace Fresco\Exceptions\Formatters;

use Fresco\Contracts\Exceptions\ExceptionFormatter;
use Throwable;

class HtmlFormatter implements ExceptionFormatter
{
    /**
     * @param Throwable $e
     */
    public function render(Throwable $e)
    {
    }
}
