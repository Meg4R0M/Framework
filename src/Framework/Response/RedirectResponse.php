<?php
/**
 * Created by PhpStorm.
 * User: fdurano
 * Date: 20/06/18
 * Time: 15:48
 */

namespace App\Framework\Response;

use GuzzleHttp\Psr7\Response;

/**
 * Class RedirectResponse
 * @package App\Framework\Response
 */
class RedirectResponse extends Response
{

    /**
     * RedirectResponse constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        parent::__construct(301, ['location' => $url]);
    }//end __construct()
}//end class
