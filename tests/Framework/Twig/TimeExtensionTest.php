<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 14:56
 */

namespace Tests\Framework\Twig;

use App\Framework\Twig\TimeExtension;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase
{

    private $timeExtension;

    public function setUp()
    {
        $this->timeExtension = new TimeExtension();
    }

    public function testDateFormat()
    {
        $date = new DateTime();
        $format = 'd/m/Y H:i';
        $result = '<span class="timeago" datetime="' . $date->format(DateTime::ISO8601) . '">'. $date->format($format) .'</span>';
        $this->assertEquals($result, $this->timeExtension->ago($date));
    }

}