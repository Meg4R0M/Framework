<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:38
 */

namespace App\Admin;

use App\Framework\Module;
use Framework\Renderer\RendererInterface;

class AdminModule extends Module
{

    /**
     *
     */
    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(RendererInterface $renderer)
    {
        $renderer->addPath('admin', __DIR__ . '/views');
    }
}
