<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 00:25
 */

namespace App\Admin;

interface AdminWidgetInterface
{

    public function render(): string;

    public function renderMenu(): string;
}
