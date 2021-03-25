<?php

use Packaged\Http\GlobalsRequest;
use Packaged\Http\Interfaces\ResponseStatus;
use Packaged\Http\Response;

include('vendor/autoload.php');

$r = GlobalsRequest::create();
echo '<pre>';
//print_r($r->headers());
print_r($r->files()->get('test-file')->getLocation());
print_r($r->post());
print_r($r->query());
var_dump($r->query()->has('a'));
var_dump($r->query()->has('ewa'));
//die;

$res = new Response('OK', ResponseStatus::OK);
$res->headers()->set('Cache-Control', 'no-cache');

$res->sendHeaders();

echo '<pre>';
echo $res->getContent();
?>
<form enctype="multipart/form-data" method="post">
  <input type="file" name="test-file">
  <input type="text" name="text-input">
  <input type="hidden" name="hidden-input" value="hideme">
  <input type="submit">
</form>
