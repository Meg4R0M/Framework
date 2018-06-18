<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 18/06/18
 * Time: 13:11
 */

namespace App\Blog;

use App\Framework\Upload;

/**
 * Class PostUpload
 * @package App\Blog
 */
class PostUpload extends Upload
{

    /**
     * @var string
     */
    protected $path = 'public/uploads/posts';

    /**
     * @var array
     */
    protected $formats = [
        'thumb' => [320, 180]
    ];
}
