<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 00:25
 */

namespace App\Admin;

/**
 * Interface AdminWidgetInterface
 * @package App\Admin
 */
interface AdminWidgetInterface
{

    /**
     * @return string
     */
    public function render(): string;

    /**
     * @return string
     */
    public function renderMenu(): string;
}
