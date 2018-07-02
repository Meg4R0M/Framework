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
use App\Auth\Mailer\PasswordResetMailer;
use App\Auth\User;
use App\Auth\UserTable;
use App\Blog\AccountWidget;
use App\Framework\Auth;
use function DI\add;
use function DI\factory;
use function DI\get;
use function DI\object;

return [
    'auth.login'               => '/login',
    'auth.entity'              => User::class,
    'twig.extensions'          => add(
        [get(AuthTwigExtension::class)]
    ),
    'admin.widgets' => add(
        [get(AccountWidget::class)]
    ),
    User::class                => factory(
        function (Auth $auth) {
            return $auth->getUser();
        }
    )->parameter('auth', get(Auth::class)),
    Auth::class                => get(DatabaseAuth::class),
    UserTable::class           => object()->constructorParameter('entity', get('auth.entity')),
    ForbiddenMiddleware::class => object()->constructorParameter('loginPath', get('auth.login')),
    PasswordResetMailer::class => object()->constructorParameter('from', get('mail.from')),
];
