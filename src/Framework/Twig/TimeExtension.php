<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 15:22
 */

namespace App\Framework\Twig;

use DateTime;
use Twig_Extension;
use Twig_SimpleFilter;

class TimeExtension extends Twig_Extension
{
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('ago', [$this, 'ago'], ['is_safe' => ['html']])
        ];
    }

    public function ago(DateTime $date, string $format = 'd/m/Y H:i')
    {
        return '<span class="timeago" datetime="' . $date->format(DateTime::ISO8601) . '">'.
            $date->format($format) .
            '</span>';
    }
}
