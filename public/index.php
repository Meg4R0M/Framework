<?php
/**
 *
 * Created by IntelliJ IDEA.
 * @author : meg4r0m
 * Date: 03/06/18
 * Time: 21:11
 */
require '../vendor/autoload.php';

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$app = new App();

$response = $app->run(ServerRequest::fromGlobals());
send($response);
