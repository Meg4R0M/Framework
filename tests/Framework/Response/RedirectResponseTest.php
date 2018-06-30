<?php
namespace Tests\Framework\Response;

use App\Framework\Response\RedirectResponse;
use PHPUnit\Framework\TestCase;

class RedirectResponseTest extends TestCase
{


    public function testStatus()
    {
        $response = new RedirectResponse('/demo');
        $this->assertEquals(301, $response->getStatusCode());
    }//end testStatus()


    public function testHeader()
    {
        $response = new RedirectResponse('/demo');
        $this->assertEquals(['/demo'], $response->getHeader('Location'));
    }//end testHeader()
}//end class
