<?php

namespace Mosaic\Definitions;

use Mosaic\Contracts\Http\Request as RequestContract;
use Mosaic\Contracts\Http\Response as ResponseContract;
use Mosaic\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Mosaic\Foundation\Components\Definition;
use Mosaic\Http\Adapters\Psr7\Request;
use Mosaic\Http\Adapters\Psr7\Response;
use Mosaic\Http\Adapters\Psr7\ResponseFactory;
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
