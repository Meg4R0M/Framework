<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 18:30
 */

namespace App\Framework\Router;

use Framework\Router;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class RouterTwigExtension
 *
 * @package App\Framework\Router
 */
class RouterTwigExtension extends Twig_Extension
{

    /**
     *
     * @var Router
     */
    private $router;


    /**
     * RouterTwigExtension constructor.
     *
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }//end __construct()


    /**
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('path', [$this, 'pathFor']),
            new Twig_SimpleFunction('is_subpath', [$this, 'isSubPath']),
        ];
    }//end getFunctions()


    /**
     *
     * @param  string $path
     * @param  array  $params
     * @return string
     */
    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }//end pathFor()


    /**
     *
     * @param  string $path
     * @return boolean
     */
    public function isSubpath(string $path): bool
    {
        $uri         = $_SERVER['REQUEST_URI'] ?? '/';
        $expectedUri = $this->router->generateUri($path);
        return strpos($uri, $expectedUri) !== false;
    }//end isSubpath()
}//end class
