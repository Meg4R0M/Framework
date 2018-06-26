<?php
namespace Tests\Framework\Auth;

use App\Framework\Auth;
use App\Framework\Auth\ForbiddenException;
use App\Framework\Auth\LoggedinMiddleware;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoggedInMiddlewareTest extends TestCase
{

    public function makeMiddleware($user)
    {
        $auth = $this->getMockBuilder(Auth::class)->getMock();
        $auth->method('getUser')->willReturn($user);
        return new LoggedInMiddleware($auth);
    }

    public function makeHandle($calls)
    {
        $handle = $this->getMockBuilder(RequestHandlerInterface::class)->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $handle->expects($calls)->method('handle')->willReturn($response);
        return $handle;
    }

    public function testThrowIfNoUser()
    {
        $request = (new ServerRequest('GET', '/demo/'));
        $this->expectException(ForbiddenException::class);
        $this->makeMiddleware(null)->process(
            $request,
            $this->makeHandle($this->never())
        );
    }

    public function testNextIfUser()
    {
        $user = $this->getMockBuilder(Auth\User::class)->getMock();
        $request = (new ServerRequest('GET', '/demo/'));
        $this->makeMiddleware($user)->process(
            $request,
            $this->makeHandle($this->once())
        );
    }
}
