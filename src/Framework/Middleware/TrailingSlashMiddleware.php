<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 11:02
 */

namespace App\Framework\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class TrailingSlashMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        return $next($request);
    }
}
