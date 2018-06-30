<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 17:30
 */

use App\Framework\Middleware\CsrfMiddleware;
use App\Framework\Router\RouterFactory;
use App\Framework\Router\RouterTwigExtension;
use App\Framework\Session\PHPSession;
use App\Framework\Session\SessionInterface;
use App\Framework\Twig\CsrfExtension;
use App\Framework\Twig\FlashExtension;
use App\Framework\Twig\FormExtension;
use App\Framework\Twig\PagerFantaExtension;
use App\Framework\Twig\TextExtension;
use App\Framework\Twig\TimeExtension;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router;
use function DI\{get, object, factory, env};
use Framework\SwiftMailerFactory;
use Psr\Container\ContainerInterface;

return [
    'env' => env('ENVIRONMENT', 'production'),
    'database.host' => 'mysql',
    'database.username' => 'root',
    'database.password' => 'root_ez',
    'database.name' => 'framework',
    'views.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        get(RouterTwigExtension::class),
        get(PagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class),
        get(FlashExtension::class),
        get(FormExtension::class),
        get(CsrfExtension::class)
    ],
    SessionInterface::class => object(PHPSession::class),
    CsrfMiddleware::class => object()->constructor(get(SessionInterface::class)),
    Router::class => factory(RouterFactory::class),
    RendererInterface::class => factory(TwigRendererFactory::class),
    PDO::class => function (ContainerInterface $container) {
        return new PDO(
            'mysql:host=' . $container->get('database.host') . ';dbname=' . $container->get('database.name'),
            $container->get('database.username'),
            $container->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    },
    // MAILER
    'mail.to'    => 'admin@admin.fr',
    'mail.from'    => 'no-reply@admin.fr',
    Swift_Mailer::class => factory(SwiftMailerFactory::class)
];