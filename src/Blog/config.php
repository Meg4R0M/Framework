<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 17:58
 */

use App\Blog\BlogWidget;
use function DI\add;
use function DI\get;

return [
    'blog.prefix' => '/blog',
    'admin.widgets' => add([
        get(BlogWidget::class)
    ])
];
