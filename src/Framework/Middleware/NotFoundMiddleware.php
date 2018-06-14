<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 14:30
 */

namespace App\Framework\Middleware;

use GuzzleHttp\Psr7\Response;

class NotFoundMiddleware
{
    public function __invoke()
    {
        return new Response(404, [], 'Erreur 404');
    }
}
