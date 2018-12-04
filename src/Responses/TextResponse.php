<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class TextResponse extends Response
{
  public static function i($text)
  {
    $resp = parent::create($text, 200, []);
    $resp->headers->set("Content-Type", "text/plain");
    return $resp;
  }
}
