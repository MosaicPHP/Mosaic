<?php

namespace Mosaic\Exceptions\Formatters;

use Mosaic\Contracts\Exceptions\ExceptionFormatter;
use Mosaic\Exceptions\ErrorResponse;
use Mosaic\Exceptions\HttpException;
use Throwable;

class HtmlFormatter implements ExceptionFormatter
{
    /**
     * @param Throwable $e
     *
     * @return ErrorResponse
     */
    public function render(Throwable $e) : ErrorResponse
    {
        return ErrorResponse::fromException($e, $this->content($e));
    }

    /**
     * @param Throwable $e
     *
     * @return string
     */
    private function content(Throwable $e)
    {
        $css     = $this->getCss();
        $title   = $this->getTitle($e);
        $content = $this->getContent($title, $e);

        return <<<EOF
<!DOCTYPE html>
<html>
    <head>
        <meta name="robots" content="noindex,nofollow" />
        <style>
            $css
        </style>
        <title>$title</title>
    </head>
    <body>
        $content
    </body>
</html>
EOF;
    }

    /**
     * @param string    $title
     * @param Throwable $e
     *
     * @return string
     */
    private function getContent(string $title, Throwable $e) : string
    {
        return <<<EOF
            <div class="container">
                <h2>Whoops!</h2>
                <h1>$title</h1>
            </div>
EOF;
    }

    /**
     * @param Throwable $e
     *
     * @return string
     */
    private function getTitle(Throwable $e) : string
    {
        switch ($this->getStatus($e)) {
            case 404:
                return 'We couldn\'t find the page you were looking for.';
                break;
            default:
                return 'Looks like something went wrong.';
        }
    }

    /**
     * @return string
     */
    private function getCss() : string
    {
        return <<<'EOF'
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-family: sans-serif;
                color: #969696;
                background-color: #f7f7f7;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            h2 {
                font-weight: 100;
                font-size: 96px;
                margin-bottom: 13px;
            }
            h1 {
                font-weight: 100;
                font-size: 26px;
                max-width: 396px;
                margin: 0 auto;
                line-height: 33px;
            }
EOF;
    }

    /**
     * @param Throwable $e
     *
     * @return int
     */
    private function getStatus(Throwable $e)
    {
        return $e instanceof HttpException ? $e->getStatusCode() : 500;
    }
}
