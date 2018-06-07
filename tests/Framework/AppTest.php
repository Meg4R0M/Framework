<?php
/**
 *
 * Created by IntelliJ IDEA.
 * @author : meg4r0m
 * Date: 03/06/18
 * Time: 21:18
 */
namespace Tests\Framework;

use App\Blog\BlogModule;
use DI\ContainerBuilder;
use Framework\App;
use Framework\Renderer\PHPRenderer;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

/**
 * Class AppTest
 * @package Tests\Framework
 */
class AppTest extends TestCase
{
    /**
     *
     */
    public function testRedirectTrailingSlash(): void
    {
        $modules = [];
        $builder = new ContainerBuilder();
        $container = $builder->build();
        $app = new App($container, $modules);
        $request = new ServerRequest('GET', '/demoslash/');
        $response = $app->run($request);
        $this->assertContains('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    /**
     *
     */
    public function testBlog(): void
    {
        $modules = [
            BlogModule::class
        ];

        $builder = new ContainerBuilder();
        $builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
        foreach ($modules as $module) {
            if ($module::DEFINITIONS) {
                $builder->addDefinitions($module::DEFINITIONS);
            }
        }
        $builder->addDefinitions(dirname(__DIR__) . '/config.php');

        $container = $builder->build();
        $app = new App($container, $modules);
        $request = new ServerRequest('GET', '/news');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/news/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertContains('<h1>Bienvenue sur l\'article article-de-test</h1>', (string)$responseSingle->getBody());
    }

    /**
     * @throws \Exception
     */
//    public function testThrowExceptionIfNoResponseSent () {
//        $modules = [];
//
//        $builder = new ContainerBuilder();
//
//        $container = $builder->build();
//        $app = new App($container, $modules);
//        $request = new ServerRequest('GET', '/demo');
//        $this->expectException(\Exception::class);
//        $app->run($request);
//    }

    /**
     * @throws \Exception
     */
//    public function testConvertStringToResponse () {
//        $modules = [
//            BlogModule::class
//        ];
//
//        $builder = new ContainerBuilder();
//        $builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
//        foreach ($modules as $module) {
//            if ($module::DEFINITIONS) {
//                $builder->addDefinitions($module::DEFINITIONS);
//            }
//        }
//        $builder->addDefinitions(dirname(__DIR__) . '/config.php');
//
//        $container = $builder->build();
//        $app = new App($container, $modules);
//        $request = new ServerRequest('GET', '/demo');
//        $response = $app->run($request);
//        $this->assertInstanceOf(ResponseInterface::class, $response);
//        $this->assertEquals('DEMO', (string)$response->getBody());
//    }

    /**
     *
     */
    public function testError404(): void
    {
        $modules = [];
        $builder = new ContainerBuilder();
        $container = $builder->build();
        $app = new App($container, $modules);
        $request = new ServerRequest('GET', '/aze');
        $response = $app->run($request);
        $this->assertContains('<h1>Erreur 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
