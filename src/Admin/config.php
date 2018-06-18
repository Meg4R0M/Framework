<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:44
 */

use App\Admin\AdminModule;
use App\Admin\AdminTwigExtension;
use App\Admin\DashboardAction;
use function DI\object;
use function DI\get;

return [
    'admin.prefix' => '/admin',
    'admin.widgets' => [],
    AdminTwigExtension::class => object()->constructor(get('admin.widgets')),
    AdminModule::class => object()->constructorParameter('prefix', get('admin.prefix')),
    DashboardAction::class =>object()->constructorParameter('widgets', get('admin.widgets'))
];
