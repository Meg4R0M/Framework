<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 07/06/18
 * Time: 18:15
 */

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use App\Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class BlogAction
 * @package App\Blog\Actions
 */
class PostShowAction
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

    use RouterAwareAction;

    /**
     * BlogAction constructor.
     * @param RendererInterface $renderer
     * @param Router $router
     * @param PostTable $postTable
     */
    public function __construct(
        RendererInterface $renderer,
        Router $router,
        PostTable $postTable
    ) {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    /**
     * Affiche un article
     *
     * @param Request $request
     * @return ResponseInterface|string
     */
    public function __invoke(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->findWithCategory($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }
        return $this->renderer->render('@blog/show', [
            'post' => $post
        ]);
    }
}
