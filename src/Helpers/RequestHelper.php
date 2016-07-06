<?php
namespace Packaged\Http\Helpers;

use Packaged\Http\Interfaces\RequestMethod;

class RequestHelper
{
  public static function supportedMethods()
  {
    return [
      RequestMethod::CONNECT => RequestMethod::CONNECT,
      RequestMethod::DELETE  => RequestMethod::DELETE,
      RequestMethod::GET     => RequestMethod::GET,
      RequestMethod::HEAD    => RequestMethod::HEAD,
      RequestMethod::OPTIONS => RequestMethod::OPTIONS,
      RequestMethod::PATCH   => RequestMethod::PATCH,
      RequestMethod::POST    => RequestMethod::POST,
      RequestMethod::PUT     => RequestMethod::PUT,
      RequestMethod::TRACE   => RequestMethod::TRACE,
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
