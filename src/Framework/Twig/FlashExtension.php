<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 08/06/18
 * Time: 23:32
 */

namespace App\Framework\Twig;

use App\Framework\Session\FlashService;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Class FlashExtension
 *
 * @package App\Framework\Twig
 */
class FlashExtension extends Twig_Extension
{

    /**
     *
     * @var FlashService
     */
    private $flashService;

    /**
     * FlashExtension constructor.
     *
     * @param FlashService $flashService
     */
    public function __construct(FlashService $flashService)
    {
        $this->flashService = $flashService;
    }//end __construct()

    /**
     *
     * @return array|\Twig_Function[]
     */
    public function getFunctions(): array
    {
        return [new Twig_SimpleFunction('flash', [$this, 'getFlash'])];
    }//end getFunctions()

    /**
     *
     * @param  $type
     * @return null|string
     */
    public function getFlash($type): ?string
    {
        return $this->flashService->get($type);
    }//end getFlash()
}//end class
