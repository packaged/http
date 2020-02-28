<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class JsonResponse extends Response
{
  public static function create($object = null, $status = 200, $headers = [])
  {
    return static::raw(json_encode($object), $status, $headers);
  }

  public static function prefixed($object = null, $status = 200, $headers = [], $prefix = ')]}\'')
  {
    return static::raw($prefix . json_encode($object), $status, $headers);
  }

  public static function p($responseKey, $object, $status = 200, $headers = [])
  {
    $responseObject = json_encode($object);
    return static::raw("{$responseKey}({$responseObject})", $status, $headers);
  }

  public static function raw($response, $status = 200, $headers = [])
  {
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
