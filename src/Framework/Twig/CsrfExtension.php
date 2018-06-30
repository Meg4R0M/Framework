<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 13/06/18
 * Time: 20:54
 */

namespace App\Framework\Twig;

use App\Framework\Middleware\CsrfMiddleware;

class CsrfExtension extends \Twig_Extension
{

    /**
     *
     * @var CsrfMiddleware
     */
    private $csrfMiddleware;


    /**
     * CsrfExtension constructor.
     *
     * @param CsrfMiddleware $csrfMiddleware
     */
    public function __construct(CsrfMiddleware $csrfMiddleware)
    {
        $this->csrfMiddleware = $csrfMiddleware;
    }//end __construct()


    public function getFunctions(): array
    {
        return [new \Twig_SimpleFunction('csrf_input', [$this, 'csrfInput'], ['is_safe' => ['html']])];
    }//end getFunctions()


    public function csrfInput(): string
    {
        return '<input type="hidden" '.
            'name="'.$this->csrfMiddleware->getFormKey().'" '.
            'value="'.$this->csrfMiddleware->generateToken().'"/>';
    }//end csrfInput()
}//end class
