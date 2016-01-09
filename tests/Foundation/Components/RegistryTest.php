<?php

namespace Fresco\Tests\Foundation\Components;

use Fresco\Contracts\Container\Container;
use Fresco\Foundation\Components\Registry;
use Interop\Container\Definition\DefinitionProviderInterface;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    public $registry;

    public function setUp()
    {
        $this->registry = new Registry();
    }

    public function test_can_define_a_definition()
    {
        $definition = new DefinitionStub();
        $this->registry->define(
            $definition
        );

        $this->assertEquals('concrete', $this->registry->getDefinitions()['abstract']);
    }

    public function tearDown()
    {
        parent::tearDown();
        Registry::flush();
    }
}

class DefinitionStub implements DefinitionProviderInterface
{
    /**
     * Returns the definition to register in the container.
     *
     * Definitions must be indexed by their entry ID. For example:
     *
     *     return [
     *         'logger' => ...
     *         'mailer' => ...
     *     ];
     *
     * @return array
     */
    public function getDefinitions()
    {
        return [
            'abstract' => 'concrete'
        ];
    }
}
