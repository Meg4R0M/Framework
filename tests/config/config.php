<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 17:30
 */

use App\Framework\Router\RouterTwigExtension;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use function DI\get;
use function DI\object;
use function DI\factory;

return [
    'views.path'             => dirname(__DIR__).'/views',
    'twig.extensions'        => [get(RouterTwigExtension::class)],
    Router::class            => object(),
    RendererInterface::class => factory(TwigRendererFactory::class),
];
