<?php
namespace Packaged\Http;

use function getallheaders;

class GlobalsRequest extends Request
{
  public static function create()
  {
    $headers = [];
    if(function_exists('getallheaders'))
    {
      $headers = getallheaders();
    }
    else
    {
      foreach($_SERVER as $key => $value)
      {
        if(0 === strpos($key, 'HTTP_'))
        {
          $headers[substr($key, 5)] = $value;
        }
        else if(\in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'], true))
        {
          $headers[$key] = $value;
        }
      }
    }

    [$uri,] = explode('?', $_SERVER['REQUEST_URI'] ?? '/', 2);
    return new static(
      $_SERVER['REQUEST_METHOD'] ?? 'GET',
      $uri,
      $_GET,
      $_POST,
      $_COOKIE,
      $_FILES,
      $headers
    );
  }
}
