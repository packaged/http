<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class JsonResponse extends Response
{
  public static function i($object)
  {
    $response = json_encode($object);

    // Prevent content sniffing attacks by encoding "<" and ">", so browsers
    // won't try to execute the document as HTML
    $response = str_replace(
      ['<', '>'],
      ['\u003c', '\u003e'],
      $response
    );

    $resp = parent::create($response, 200, []);
    $resp->headers->set("Content-Type", "application/json");

    return $resp;
  }
}
