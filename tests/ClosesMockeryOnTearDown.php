<?php

namespace Mosaic\Tests;

trait ClosesMockeryOnTearDown
{
    /**
     * @after
     */
    protected function closeMockery()
    {
        \Mockery::close();
    }
}
