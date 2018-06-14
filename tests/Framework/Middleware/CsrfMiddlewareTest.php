<?php
namespace Tests\Framework\Middleware;

use App\Framework\Exception\CsrfInvalidException;
use App\Framework\Middleware\CsrfMiddleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

class CsrfMiddlewareTest extends TestCase {

    /**
     * @var CsrfMiddleware
     */
    private $csrfMiddleware;

    /**
     * @var
     */
    private $session;

    public function setUp()
    {
        $this->session = [];
        $this->csrfMiddleware = new CsrfMiddleware($this->session);
    }

    /**
     * @throws \Exception
     */
    public function testLetGetRequestPass (): void
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handler->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $request = new ServerRequest('GET', '/demo');
        $this->csrfMiddleware->process($request, $handler);
    }

    /**
     * @throws \Exception
     */
    public function testBlockPostRequestWithoutCsrf (): void
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handler->expects($this->never())->method('handle');

        $request = new ServerRequest('POST', '/demo');
        $this->expectException(CsrfInvalidException::class);
        $this->csrfMiddleware->process($request, $handler);
    }

    /**
     * @throws \Exception
     */
    public function testBlockPostRequestWithInvalidCsrf (): void
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handler->expects($this->never())->method('handle');

        $request = new ServerRequest('POST', '/demo');
        $this->csrfMiddleware->generateToken();
        $request = $request->withParsedBody(['_csrf' => 'azeaze']);
        $this->expectException(CsrfInvalidException::class);
        $this->csrfMiddleware->process($request, $handler);
    }

    /**
     * @throws \Exception
     */
    public function testLetPostWithTokenPass (): void
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handler->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $request = new ServerRequest('POST', '/demo');
        $token = $this->csrfMiddleware->generateToken();
        $request = $request->withParsedBody(['_csrf' => $token]);
        $this->csrfMiddleware->process($request, $handler);
    }

    /**
     * @throws \Exception
     */
    public function testLetPostWithTokenPassOnce (): void
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)
            ->setMethods(['handle'])
            ->getMock();

        $handler->expects($this->once())
            ->method('handle')
            ->willReturn(new Response());

        $request = new ServerRequest('POST', '/demo');
        $token = $this->csrfMiddleware->generateToken();
        $request = $request->withParsedBody(['_csrf' => $token]);
        $this->csrfMiddleware->process($request, $handler);
        $this->expectException(CsrfInvalidException::class);
        $this->csrfMiddleware->process($request, $handler);
    }

    public function testLimitTheTokenNumber (): void
    {
        for($i =0; $i < 100; ++$i){
            $token = $this->csrfMiddleware->generateToken();
        }
        $this->assertCount(50, $this->session['csrf']);
        $this->assertEquals($token, $this->session['csrf'][49]);
    }
}