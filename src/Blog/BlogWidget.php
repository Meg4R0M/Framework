<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 10/06/18
 * Time: 00:26
 */

namespace App\Blog;

use App\Admin\AdminWidgetInterface;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;

class BlogWidget implements AdminWidgetInterface
{

    /**
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     *
     * @var PostTable
     */
    private $postTable;


    public function __construct(RendererInterface $renderer, PostTable $postTable)
    {
        $this->renderer  = $renderer;
        $this->postTable = $postTable;
    }//end __construct()


    public function render(): string
    {
        $count = $this->postTable->count();
        return $this->renderer->render('@blog/admin/widget', compact('count'));
    }//end render()


    public function renderMenu(): string
    {
        return $this->renderer->render('@blog/admin/menu');
    }//end renderMenu()
}//end class
