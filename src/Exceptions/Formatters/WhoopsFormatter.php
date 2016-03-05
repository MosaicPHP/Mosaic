<?php

namespace Mosaic\Exceptions\Formatters;

use Mosaic\Contracts\Exceptions\ExceptionFormatter;
use Mosaic\Exceptions\ErrorResponse;
use Mosaic\Support\HtmlString;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsFormatter implements ExceptionFormatter
{
    /**
     * @var Run
     */
    private $whoops;

    /**
     * @param Run $whoops
     */
    public function __construct(Run $whoops)
    {
        $this->whoops = $whoops;
        $this->whoops->allowQuit(false);
        $this->whoops->writeToOutput(false);
        $this->whoops->pushHandler(new PrettyPageHandler);
    }

    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    public function render(Throwable $e) : ErrorResponse
    {
        $output = new HtmlString(
            $this->whoops->handleException($e)
        );

        return ErrorResponse::fromException($e, $output);
    }
}
