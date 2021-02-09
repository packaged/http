<?php

use Packaged\Http\Interfaces\ResponseStatus;
use Packaged\Http\Request;
use Packaged\Http\Response;

include('vendor/autoload.php');

$r = Request::createFromGlobals();
$res = new Response('OK', ResponseStatus::OK);
$res->headers()->set('Cache-Control', 'no-cache');

$res->sendHeaders();

echo '<pre>';
echo $res->getContent();

print_r($r);
