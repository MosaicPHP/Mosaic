<?php

namespace Mosaic\Contracts\View;

interface Factory
{
    /**
     * @param string $file
     * @param array  $data
     *
     * @return View
     */
    public function make(string $file, array $data = []);
}
