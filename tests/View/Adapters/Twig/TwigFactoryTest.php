<?php

namespace Fresco\Tests\View\Adapters\Twig;

use Fresco\Contracts\View\View;
use Fresco\View\Adapters\Twig\Factory;
use PHPUnit_Framework_TestCase;

class TwigFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\Mock
     */
    private $twig;

    /**
     * @var Factory
     */
    private $factory;

    public function setUp()
    {
        $this->twig = \Mockery::mock(\Twig_Environment::class);

        $this->factory = new Factory(
            $this->twig
        );
    }

    public function test_can_make_a_twig_view()
    {
        $viewName = 'welcome.html';
        $data     = ['variable' => 'value'];

        $this->twig->shouldReceive('loadTemplate')->with($viewName)->once()->andReturn(\Mockery::mock(\Twig_TemplateInterface::class));

        $view = $this->factory->make($viewName, $data);

        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals($data, $view->getData());
    }
}
