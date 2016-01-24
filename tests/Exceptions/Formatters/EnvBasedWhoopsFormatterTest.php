<?php

namespace Fresco\Tests\Exceptions\Formatters;

use Fresco\Contracts\Application;
use Fresco\Exceptions\Formatters\HtmlFormatter;
use Fresco\Exceptions\Formatters\SmartFormatter;
use Fresco\Exceptions\Formatters\WhoopsFormatter;
use PHPUnit_Framework_TestCase;

class EnvBasedWhoopsFormatterTest extends PHPUnit_Framework_TestCase
{
    public function test_it_delegates_on_whoops_if_app_is_local()
    {
        $app           = \Mockery::mock(Application::class);
        $whoops        = \Mockery::mock(WhoopsFormatter::class);
        $htmlFormatter = \Mockery::mock(HtmlFormatter::class);

        $app->shouldReceive('isLocal')->once()->andReturn(true);
        $whoops->shouldReceive('render')->once()->with($e = new \InvalidArgumentException());
        $htmlFormatter->shouldReceive('render')->never();

        $formatter = new SmartFormatter($app, $whoops, $htmlFormatter);
        $formatter->render($e);
    }

    public function test_it_delegates_on_html_if_app_is_not_local()
    {
        $app           = \Mockery::mock(Application::class);
        $whoops        = \Mockery::mock(WhoopsFormatter::class);
        $htmlFormatter = \Mockery::mock(HtmlFormatter::class);

        $app->shouldReceive('isLocal')->once()->andReturn(false);
        $whoops->shouldReceive('render')->never();
        $htmlFormatter->shouldReceive('render')->once()->with($e = new \InvalidArgumentException());

        $formatter = new SmartFormatter($app, $whoops, $htmlFormatter);
        $formatter->render($e);
    }
}
