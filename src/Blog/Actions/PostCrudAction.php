<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:53
 */
namespace App\Blog\Actions;

use App\Blog\Entity\Post;
use App\Blog\PostUpload;
use App\Blog\Table\CategoryTable;
use App\Blog\Table\PostTable;
use App\Framework\Actions\CrudAction;
use App\Framework\Session\FlashService;
use App\Framework\Validator;
use DateTime;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface;
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
     * @var PostUpload
     */
    private $postUpload;

    /**
     * PostCrudAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $table
     * @param FlashService $flash
     * @param CategoryTable $categoryTable
     * @param PostUpload $postUpload
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $table,
        FlashService $flash,
        CategoryTable $categoryTable,
        PostUpload $postUpload
    ) {
        parent::__construct($renderer, $router, $table, $flash);
        $this->categoryTable = $categoryTable;
        $this->postUpload = $postUpload;
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $post = $this->table->find($request->getAttribute('id'));
        $this->postUpload->delete($post->image);
        return parent::delete($request);
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
        $post->createdAt = new DateTime();
        return $post;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Post $post
     * @return array
     */
    protected function prePersist(ServerRequestInterface $request, $post): array
    {
        $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());
        // Uploader le fichier
        $image = $this->postUpload->upload($params['image'], $post->image);
        if ($image) {
            $params['image'] = $image;
        } else {
            unset($params['image']);
        }
        $params = array_filter($params, function ($key) {
            return \in_array($key, ['name', 'slug', 'content', 'createdAt', 'categoryId', 'image', 'published']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, ['updatedAt' => date('Y-m-d H:i:s')]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return Validator
     */
    protected function getValidator(ServerRequestInterface $request): Validator
    {
        $validator = parent::getValidator($request)
            ->required('content', 'name', 'slug', 'createdAt', 'categoryId')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->exists('categoryId', $this->categoryTable->getTable(), $this->categoryTable->getPdo())
            ->dateTime('createdAt')
            ->extension('image', ['jpg', 'png'])
            ->slug('slug');
        if (null === $request->getAttribute('id')) {
            $validator->uploaded('image');
        }
        return $validator;
    }
}
