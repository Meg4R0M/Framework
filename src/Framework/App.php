<?php
/**
 * Created by IntelliJ IDEA.
 *
 * @author Squiz Pty Ltd <products@squiz.net>
 * Date: 03/06/18
 * Time: 21:11
 */

namespace Framework;

use App\Framework\Middleware\CombinedMiddleware;
use App\Framework\Middleware\RoutePrefixedMiddleware;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\ApcuCache;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class App implements RequestHandlerInterface
{

    /**
     * List of modules
     *
     * @var array
     */
    private $modules = [];

    /**
     *
     * @var array
     */
    private $definitions;

    /**
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     *
     * @var string[]
     */
    private $middlewares = [];

    /**
     *
     * @var integer
     */
    private $index = 0;


    /**
     * App constructor.
     *
     * @param null|string|array $definitions
     */
    public function __construct($definitions = [])
    {
        if (is_string($definitions)) {
            $definitions = [$definitions];
        }
        if (!$this->isSequential($definitions)) {
            $definitions = [$definitions];
        }
        $this->definitions = $definitions;
    }//end __construct()


    /**
     * Rajoute un module à l'application
     *
     * @param  string $module
     * @return App
     */
    public function addModule(string $module): self
    {
        $this->modules[] = $module;
        return $this;
    }//end addModule()


    /**
     * Ajoute un middleware
     *
     * @param  string|callable|MiddlewareInterface      $routePrefix
     * @param  null|string|callable|MiddlewareInterface $middleware
     * @return App
     */
    public function pipe($routePrefix, $middleware = null): self
    {
        if ($middleware === null) {
            $this->middlewares[] = $routePrefix;
        } else {
            $this->middlewares[] = new RoutePrefixedMiddleware($this->getContainer(), $routePrefix, $middleware);
        }
        return $this;
    }//end pipe()


    /**
     * Handle the request and return a response.
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->index++;
        if ($this->index > 1) {
            throw new \Exception();
        }
        $middleware = new CombinedMiddleware($this->getContainer(), $this->middlewares);
        return $middleware->process($request, $this);
    }//end handle()


    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }
        return $this->handle($request);
    }//end run()


    /**
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $env     = getenv('ENVIRONMENT') ?: 'production';
            if ($env === 'production') {
                $builder->setDefinitionCache(new ApcuCache());
                $builder->writeProxiesToFile(true, 'tmp/proxies');
            }
            foreach ($this->definitions as $definition) {
                $builder->addDefinitions($definition);
            }
            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $builder->addDefinitions(
                [self::class => $this]
            );
            $this->container = $builder->build();
        }//end if
        return $this->container;
    }//end getContainer()


    /**
     *
     * @return array
     */
    public function getModules(): array
    {
        return $this->modules;
    }//end getModules()


    private function isSequential(array $array): bool
    {
        if (empty($array)) {
            return true;
        }
        return array_keys($array) === range(0, (count($array) - 1));
    }//end isSequential()
}//end class
