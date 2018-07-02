<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 00:26
 */

namespace App\Blog;

use App\Admin\AdminWidgetInterface;
use App\Auth\UserTable;
use Framework\Renderer\RendererInterface;

class AccountWidget implements AdminWidgetInterface
{

    /**
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     *
     * @var UserTable
     */
    private $userTable;


    public function __construct(RendererInterface $renderer, UserTable $userTable)
    {
        $this->renderer  = $renderer;
        $this->userTable = $userTable;
    }//end __construct()


    public function render(): string
    {
        $count = $this->userTable->count();
        return $this->renderer->render('@account/admin/widget', compact('count'));
    }//end render()


    public function renderMenu(): string
    {
        return $this->renderer->render('@account/admin/menu');
    }//end renderMenu()
}//end class
