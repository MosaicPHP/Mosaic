<?php
namespace Fresco\Tests;

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
