<?php
/**
 * Created by IntelliJ IDEA.
 * @author : meg4r0m
 * Date: 03/06/18
 * Time: 21:11
 */
require '../vendor/autoload.php';

use App\Blog\BlogModule;
use Framework\App;
use Framework\Renderer;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$renderer = new Renderer();
$renderer->addPath(dirname(__DIR__) . '/views');

$app = new App([
    BlogModule::class
], [
    'renderer' => $renderer
]);

$response = $app->run(ServerRequest::fromGlobals());
send($response);
