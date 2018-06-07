<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 21:26
 */

namespace Tests\Framework\Modules;

use Framework\Router;

/**
 * Class StringModule
 * @package Tests\Framework\Modules
 */
class StringModule
{
    /**
     * StringModule constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/demo', function () {
            return 'DEMO';
        }, 'demo');
    }
}