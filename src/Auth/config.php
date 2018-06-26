<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 19/06/18
 * Time: 06:58
 */

use App\Auth\AuthTwigExtension;
use App\Auth\DatabaseAuth;
use App\Auth\ForbiddenMiddleware;
use App\Framework\Auth;
use function DI\add;
use function DI\get;
use function DI\object;

return [
    'auth.login' => '/login',
    'twig.extensions' => add([
        get(AuthTwigExtension::class)
    ]),
    Auth::class => get(DatabaseAuth::class),
    ForbiddenMiddleware::class => object()->constructorParameter('loginPath', get('auth.login'))
];
