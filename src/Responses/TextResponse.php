<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class TextResponse extends Response
{
  public static function create($text = '', $status = 200, $headers = []): static
  {
    $resp = parent::create($text, $status, $headers);
    $resp->headers->set("Content-Type", "text/plain");
    return $resp;
  }
}
