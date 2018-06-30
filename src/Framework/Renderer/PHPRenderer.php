<?php

namespace Framework\Renderer;

/**
 * Class Renderer
 *
 * @package Framework
 */
class PHPRenderer implements RendererInterface
{

    /**
     *
     */
    const DEFAULT_NAMESPACE = '__MAIN';

    /**
     *
     * @var array
     */
    private $paths = [];

    /**
     * Variables globalement accessibles pour toutes les vues
     *
     * @var array
     */
    private $globals = [];


    public function __construct(?string $defaultPath = null)
    {
        if (!is_null($defaultPath)) {
            $this->addPath($defaultPath);
        }
    }//end __construct()


    /**
     * Permet de rajouter un chamin pour charger les vues
     *
     * @param string      $namespace
     * @param null|string $path
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }//end addPath()


    /**
     * Permet de rendre une vue
     * Le chemin peut être précisé avec des namespace rajoutés via addPath()
     * $this->render('@blog/view');
     * $this->render('view');
     *
     * @param  string $view
     * @param  array  $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view).'.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        include $path;
        return ob_get_clean();
    }//end render()


    /**
     * Permet de rajouter des variables globales à toutes les vues
     *
     * @param string $key
     * @param mixed  $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key] = $value;
    }//end addGlobal()


    /**
     *
     * @param  string $view
     * @return boolean
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }//end hasNamespace()


    /**
     *
     * @param  string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, (strpos($view, '/') - 1));
    }//end getNamespace()


    /**
     *
     * @param  string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@'.$namespace, $this->paths[$namespace], $view);
    }//end replaceNamespace()
}//end class
