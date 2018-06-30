<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 14:30
 */

namespace App\Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{


    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        return new Response(404, [], 'Erreur 404');
    }//end __invoke()
}//end class
