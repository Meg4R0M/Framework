<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 17:53
 */
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use App\Framework\Actions\RouterAwareAction;
use App\Framework\Session\FlashService;
use App\Framework\Session\SessionInterface;
use App\Framework\Validator;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class AdminBlogAction
 * @package App\Blog\Actions
 */
class AdminBlogAction
{

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var PostTable
     */
    private $postTable;

    /**
     * @var FlashService
     */
    private $flash;

    use RouterAwareAction;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $postTable
     * @param FlashService $flash
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $postTable,
        FlashService $flash
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
        $this->flash = $flash;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        }
        return $this->index($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        $items = $this->postTable->findPaginated(12, $params['p'] ?? 1);

        return $this->renderer->render('@blog/admin/index', compact('items', 'session'));
    }

    /**
     * Edite un article
     *
     * @param Request $request
     * @return \Psr\Http\Message\ResponseInterface|string
     */
    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->update($item->id, $params);
                $this->flash->success('L\'article a bien été modifié');
                return $this->redirect('blog.admin.index');
            }
            $errors = $validator->getErrors();
            $params['id'] = $item->id;
            $item = $params;
        }

        return $this->renderer->render('@blog/admin/edit', compact('item', 'errors'));
    }

    public function create(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $validator = $this->getValidator($request);
            if ($validator->isValid()) {
                $this->postTable->insert($params);
                $this->flash->success('L\'article a bien été crée');
                return $this->redirect('blog.admin.index');
            }
            $errors = $validator->getErrors();
            $item = $params;
        }

        return $this->renderer->render('@blog/admin/create', compact('item', 'errors'));
    }

    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        $this->flash->success('L\'article a bien été supprimé');
        return $this->redirect('blog.admin.index');
    }

    private function getParams(Request $request)
    {
        $params = array_filter($request->getParsedBody(), function ($key) {
            return \in_array($key, ['name', 'content', 'slug', 'crreated_at']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    private function getValidator(Request $request)
    {
        return (new Validator($request->getParsedBody()))
            ->required('content', 'name', 'slug')
            ->length('content', 10)
            ->length('name', 2, 250)
            ->length('slug', 2, 50)
            ->slug('slug');
    }
}
