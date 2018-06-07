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
        $app = new App();
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
        $renderer = new PHPRenderer(dirname(__DIR__) . '/views');
        $app = new App([
            BlogModule::class
        ], [
            'renderer' => $renderer
        ]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/blog/article-de-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertContains('<h1>Bienvenue sur l\'article article-de-test</h1>', (string)$responseSingle->getBody());
    }

    /**
     * @throws \Exception
     */
    public function testThrowExceptionIfNoResponseSent () {
        $renderer = new PHPRenderer(dirname(__DIR__) . '/views');
        $app = new App([
            ErroredModule::class
        ], [
            'renderer' => $renderer
        ]);
        $request = new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    /**
     * @throws \Exception
     */
    public function testConvertStringToResponse () {
        $renderer = new PHPRenderer(dirname(__DIR__) . '/views');
        $app = new App([
            StringModule::class
        ], [
            'renderer' => $renderer
        ]);
        $request = new ServerRequest('GET', '/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('DEMO', (string)$response->getBody());
    }

    /**
     *
     */
    public function testError404(): void
    {
        $app = new App();
        $request = new ServerRequest('GET', '/aze');
        $response = $app->run($request);
        $this->assertContains('<h1>Erreur 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}
