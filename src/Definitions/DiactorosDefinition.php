<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Http\Request as RequestContract;
use Fresco\Contracts\Http\Response as ResponseContract;
use Fresco\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Fresco\Foundation\Components\Definition;
use Fresco\Http\Adapters\Psr7\Request;
use Fresco\Http\Adapters\Psr7\Response;
use Fresco\Http\Adapters\Psr7\ResponseFactory;
use Interop\Container\Definition\DefinitionProviderInterface;
use Zend\Diactoros\Response as DiactorosResponse;
use Zend\Diactoros\ServerRequestFactory;

class DiactorosDefinition implements DefinitionProviderInterface
{
    /**
     * @return array|Definition[]
     */
    public function getDefinitions() : array
    {
        return [
            RequestContract::class  => function () {
                return new Request(
                    ServerRequestFactory::fromGlobals()
                );
            },
            ResponseContract::class => function () {
                return new Response(
                    new DiactorosResponse
                );
            },
            ResponseFactoryContract::class => function () {
                return new ResponseFactory;
            }
        ];
    }
}
