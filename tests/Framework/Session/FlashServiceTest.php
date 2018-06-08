<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 23:43
 */

namespace Tests\Framework\Session;

use App\Framework\Session\ArraySession;
use App\Framework\Session\FlashService;
use PHPUnit\Framework\TestCase;

/**
 * Class FlashServiceTest
 * @package Tests\Framework\Session
 */
class FlashServiceTest extends TestCase
{

    /**
     * @var ArraySession
     */
    private $flashService;

    /**
     * @var FlashService
     */
    private $session;

    /**
     *
     */
    public function setUp()
    {
        $this->session = new ArraySession();
        $this->flashService = new FlashService($this->session);
    }

    /**
     *
     */
    public function testDeleteFlashAfterGettingIt()
    {
        $this->flashService->success('Bravo');
        $this->assertEquals('Bravo', $this->flashService->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('Bravo', $this->flashService->get('success'));
        $this->assertEquals('Bravo', $this->flashService->get('success'));
        $this->assertEquals('Bravo', $this->flashService->get('success'));
    }

}