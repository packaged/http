<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class JsonResponse extends Response
{
  public static function create($object = null, $status = 200, $headers = [])
  {
    $response = json_encode($object);

    // Prevent content sniffing attacks by encoding "<" and ">", so browsers
    // won't try to execute the document as HTML
    $response = str_replace(
      ['<', '>'],
      ['\u003c', '\u003e'],
      $response
    );

    $resp = parent::create($response, $status, $headers);
    $resp->headers->set("Content-Type", "application/json");

    return $resp;
  }

  public static function p($responseKey, $object, $status = 200, $headers = [])
  {
    $responseObject = json_encode($object);
    $response = "{$responseKey}({$responseObject})";

    // Prevent content sniffing attacks by encoding "<" and ">", so browsers
    // won't try to execute the document as HTML
    $response = str_replace(
      ['<', '>'],
      ['\u003c', '\u003e'],
      $response
    );

    $resp = parent::create($response, $status, $headers);
    $resp->headers->set("Content-Type", "application/json");

    return $resp;
  }
}
