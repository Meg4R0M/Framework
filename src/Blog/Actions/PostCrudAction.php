<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:53
 */
namespace App\Blog\Actions;

use App\Blog\Entity\Post;
use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use App\Framework\Actions\CrudAction;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use DateTime;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AdminBlogAction
 * @package App\Blog\Actions
 */
class PostCrudAction extends CrudAction
{

    /**
     * @var string
     */
    protected $viewPath = '@blog/admin/posts';

    /**
     * @var string
     */
    protected $routePrefix = 'blog.admin';

    /**
     * @var CategoryTable
     */
    private $categoryTable;

    /**
     * PostCrudAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $table
     * @param FlashService $flash
     * @param CategoryTable $categoryTable
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $table,
        FlashService $flash,
        CategoryTable $categoryTable
    ) {
        parent::__construct($renderer, $router, $table, $flash);
        $this->categoryTable = $categoryTable;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function formParams(array $params): array
    {
        $params['categories'] = $this->categoryTable->findList();
        $params['categories'][13123123] = 'Categorie fake';
        return $params;
    }

    /**
     * @return Post|array
     */
    protected function getNewEntity()
    {
        $post = new Post();
        $post->created_at = new DateTime();
        return $post;
    }

    /**
     * @param ServerRequestInterface $request
     * @return array
     */
    protected function getParams(ServerRequestInterface $request): array
    {
        $params = array_filter($request->getParsedBody(), function ($key) {
            return \in_array($key, ['name', 'content', 'slug', 'created_at', 'category_id']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Validator
     */
    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return parent::getValidator($request)
            ->required('content', 'name', 'slug', 'created_at', 'category_id')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->exists('category_id', $this->categoryTable->getTable(), $this->categoryTable->getPdo())
            ->dateTime('created_at')
            ->slug('slug');
    }
}
