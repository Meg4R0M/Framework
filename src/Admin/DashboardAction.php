<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 00:16
 */

namespace App\Admin;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class DashboardAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var AdminWidgetInterface[]
     */
    private $widgets;

    /**
     * DashboardAction constructor.
     * @param RendererInterface $renderer
     * @param array $widgets
     */
    public function __construct(RendererInterface $renderer, array $widgets)
    {
        $this->renderer = $renderer;
        $this->widgets = $widgets;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $widgets = array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->render();
        }, '');
        return $this->renderer->render('@admin/dashboard', compact('widgets'));
    }

    public function process(ServerRequestInterface $request): string
    {
        return $this->__invoke($request);
    }
}
