<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 22:17
 */

namespace App\Blog\Actions;

use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use App\Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class CategoryShowAction
 * @package App\Blog\Actions
 */
class CategoryShowAction
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

    /**
     *
     * @var CategoryTable
     */
    private $categoryTable;

    use RouterAwareAction;

    /**
     * BlogAction constructor.
     *
     * @param RendererInterface $renderer
     * @param PostTable         $postTable
     * @param CategoryTable     $categoryTable
     */
    public function __construct(
        RendererInterface $renderer,
        PostTable $postTable,
        CategoryTable $categoryTable
    ) {
        $this->renderer      = $renderer;
        $this->postTable     = $postTable;
        $this->categoryTable = $categoryTable;
    }//end __construct()

    /**
     * @param Request $request
     * @return string
     * @throws \App\Framework\Database\NoRecordException
     */
    public function __invoke(Request $request)
    {
        $params     = $request->getQueryParams();
        $category   = $this->categoryTable->findBy('slug', $request->getAttribute('slug'));
        $posts      = $this->postTable->findPublicForCategory($category->id)->paginate(12, ($params['p'] ?? 1));
        $categories = $this->categoryTable->findAll();
        $page       = ($params['p'] ?? 1);

        return $this->renderer->render('@blog/index', compact('posts', 'categories', 'category', 'page'));
    }//end __invoke()
}//end class
