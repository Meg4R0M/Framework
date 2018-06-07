<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 04/06/18
 * Time: 21:17
 */
namespace Tests\Framework\Modules;

use Framework\Router;
use stdClass;

/**
 * Class ErroredModule
 * @package Tests\Framework\Modules
 */
class ErroredModule {

    /**
     * ErroredModule constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $router->get('/demo', function () {
            return new stdClass();
        }, 'demo');
    }
}