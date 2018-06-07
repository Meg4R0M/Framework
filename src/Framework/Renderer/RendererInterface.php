<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 15:24
 */

namespace Framework\Renderer;

/**
 * Interface RendererInterface
 * @package Framework\Renderer
 */
interface RendererInterface
{

    /**
     * @param string $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * @param string $key
     * @param $value
     */
    public function addGlobal(string $key, $value): void;
}
