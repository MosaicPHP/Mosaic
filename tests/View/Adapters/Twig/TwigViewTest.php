<?php

namespace Fresco\Tests\View\Adapters\Twig;

use Fresco\Tests\View\ViewTest;
use Fresco\View\Adapters\Twig\View;
use Mockery\Mock;

class TwigViewTest extends ViewTest
{
    /**
     * @var Mock
     */
    private $twig;

    /**
     * @var View
     */
    private $view;

    public function setUp()
    {
        $this->twig = \Mockery::mock(\Twig_TemplateInterface::class);

        $this->view = new View(
            $this->twig,
            ['variable' => 'value']
        );
    }

    public function test_can_render_a_view()
    {
        $this->twig->shouldReceive('render')->with(['variable' => 'value'])->once()->andReturn('rendered');

        $response = $this->view->render();

        $this->assertEquals('rendered', $response);
    }

    public function test_can_cast_view_to_string()
    {
        $this->twig->shouldReceive('render')->with(['variable' => 'value'])->once()->andReturn('rendered');

        $this->assertEquals('rendered', (string) $this->view);
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }
}
