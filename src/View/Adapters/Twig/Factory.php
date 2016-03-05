<?php

namespace Mosaic\View\Adapters\Twig;

use Mosaic\Contracts\View\Factory as ViewFactory;
use Mosaic\Contracts\View\View as ViewContract;
use Twig_Environment;

class Factory implements ViewFactory
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * Factory constructor.
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $file
     * @param array  $data
     *
     * @return ViewContract
     */
    public function make(string $file, array $data = [])
    {
        return new View(
            $this->twig->loadTemplate($file),
            $data
        );
    }
}
