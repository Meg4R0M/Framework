<?php
namespace Tests\App\Auth;

use App\Auth\ForbiddenMiddleware;
use App\Framework\Session\ArraySession;
use App\Framework\Auth\ForbiddenException;
use App\Framework\Auth\User;
use App\Framework\Session\SessionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ForbiddenMiddlewareTest extends TestCase
{

    /**
     * @var SessionInterface
     */
    private $session;

    public function setUp()
    {
        $this->session = new ArraySession();
    }

    public function makeRequest($path = '/')
    {
        $uri = $this->getMockBuilder(UriInterface::class)->getMock();
        $uri->method('getPath')->willReturn($path);
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $request->method('getUri')->willReturn($uri);
        return $request;
    }

    public function makeHandle()
    {
        $handler = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        return $handler;
    }

    public function makeMiddleware()
    {
        return new ForbiddenMiddleware('/login', $this->session);
    }

    public function testCatchForbiddenException()
    {
        $handle = $this->makeHandle();
        $handle->expects($this->once())->method('handle')->willThrowException(new ForbiddenException());
        $response = $this->makeMiddleware()->process($this->makeRequest('/test'), $handle);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/login'], $response->getHeader('Location'));
        $this->assertEquals('/test', $this->session->get('auth.redirect'));
    }

    public function testCatchTypeErrorException()
    {
        $handle = $this->makeHandle();
        $handle->expects($this->once())->method('handle')->willReturnCallback(function (User $user) {
            return true;
        });
        $response = $this->makeMiddleware()->process($this->makeRequest('/test'), $handle);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/login'], $response->getHeader('Location'));
        $this->assertEquals('/test', $this->session->get('auth.redirect'));
    }

    public function testBubbleError()
    {
        $handle = $this->makeHandle();
        $handle->expects($this->once())->method('handle')->willReturnCallback(function () {
            throw new \TypeError("test", 200);
        });
        try {
            $this->makeMiddleware()->process($this->makeRequest('/test'), $handle);
        } catch (\TypeError $e) {
            $this->assertEquals("test", $e->getMessage());
            $this->assertEquals(200, $e->getCode());
        }
    }

    public function testProcessValidRequest()
    {
        $handle = $this->makeHandle();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $handle
            ->expects($this->once())
            ->method('handle')
            ->willReturn($response);
        $this->assertSame($response, $this->makeMiddleware()->process($this->makeRequest('/test'), $handle));
    }
}
