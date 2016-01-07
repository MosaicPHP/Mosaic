<?php

namespace Fresco\View\Adapters\Twig;

use ArrayAccess;
use Fresco\Contracts\View\View as ViewContract;
use Fresco\View\View as AbstractView;
use Twig_TemplateInterface;

class View extends AbstractView implements ViewContract, ArrayAccess
{
    /**
     * @var Twig_TemplateInterface
     */
    private $template;

    /**
     * @param Twig_TemplateInterface $template
     * @param array                  $data
     */
    public function __construct(Twig_TemplateInterface $template, array $data = [])
    {
        $this->with($data);
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->template->render($this->getData());
    }
}
