<?php

namespace Fresco\Tests\View;

use Fresco\Contracts\View\View;
use Fresco\Tests\ClosesMockeryOnTearDown;
use PHPUnit_Framework_TestCase;

abstract class ViewTest extends PHPUnit_Framework_TestCase
{
    use ClosesMockeryOnTearDown;

    abstract public function test_can_render_a_view();

    abstract public function test_can_cast_view_to_string();

    public function test_can_add_variable_to_view()
    {
        $this->getView()->with('new', 'value');

        $data = $this->getView()->getData();

        $this->assertArrayHasKey('new', $data);
        $this->assertEquals('value', $data['new']);
    }

    public function test_can_add_variables_to_view()
    {
        $this->getView()->with([
            'new'  => 'value',
            'new2' => 'value2'
        ]);

        $data = $this->getView()->getData();

        $this->assertArrayHasKey('new', $data);
        $this->assertEquals('value', $data['new']);

        $this->assertArrayHasKey('new2', $data);
        $this->assertEquals('value2', $data['new2']);
    }

    public function test_can_magic_set_variables_to_view()
    {
        $view      = $this->getView();
        $view->new = 'value';

        $data = $this->getView()->getData();

        $this->assertArrayHasKey('new', $data);
        $this->assertEquals('value', $data['new']);
    }

    public function test_can_magic_get_variables_from_view()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertEquals('value', $view->new);
    }

    public function test_can_check_if_variable_exists()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertTrue(isset($view->new));
        $this->assertFalse(isset($view->bar));
    }

    public function test_can_unset_variables_from_view()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertTrue(isset($view->new));

        unset($view->new);

        $this->assertFalse(isset($view->new));
    }

    public function test_can_add_variables_as_array_keys()
    {
        $view        = $this->getView();
        $view['new'] = 'value';

        $data = $this->getView()->getData();

        $this->assertArrayHasKey('new', $data);
        $this->assertEquals('value', $data['new']);
    }

    public function test_can_get_variables_as_array_keys()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertEquals('value', $view['new']);
    }

    public function test_can_check_if_array_notated_variable_exists()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertTrue(isset($view['new']));
        $this->assertFalse(isset($view['bar']));
    }

    public function test_can_unset_array_notated_variables_from_view()
    {
        $view = $this->getView();
        $view->with('new', 'value');

        $this->assertTrue(isset($view['new']));

        unset($view['new']);

        $this->assertFalse(isset($view['new']));
    }

    /**
     * @return View
     */
    abstract public function getView();
}
