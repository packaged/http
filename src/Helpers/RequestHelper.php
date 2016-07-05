<?php
namespace Packaged\Http\Helpers;

class RequestHelper
{
  public static function supportedMethods()
  {
    return [
      'CONNECT' => 'CONNECT',
      'DELETE'  => 'DELETE',
      'GET'     => 'GET',
      'HEAD'    => 'HEAD',
      'OPTIONS' => 'OPTIONS',
      'PATCH'   => 'PATCH',
      'POST'    => 'POST',
      'PUT'     => 'PUT',
      'TRACE'   => 'TRACE',
    ];
  }

  public static function validateMethod($method)
  {
    if($method !== null)
    {
      if(!is_string($method))
      {
        throw new \InvalidArgumentException('Method should be a string');
      }

      $method = strtoupper($method);

      if(!in_array($method, static::supportedMethods()))
      {
        throw new \InvalidArgumentException('Invalid HTTP method: ' . $method);
      }
    }
    return $method;
  }
}
