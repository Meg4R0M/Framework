<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 11:50
 */

namespace App\Framework\Actions;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Rajoute des méthodes liées à l'utilisation du Router
 *
 * Trait RouterAwareAction
 * @package App\Framework\Actions
 */
trait RouterAwareAction
{

    /**
     * Renvoi une réponse de redirection
     *
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('Location', $redirectUri);
    }
}
