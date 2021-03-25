<?php
namespace Packaged\Http;

class GlobalsRequest extends Request
{
  public static function create()
  {
    [$uri,] = explode('?', $_SERVER['REQUEST_URI'], 2);
    return new static(
      $_SERVER['REQUEST_METHOD'],
      $uri,
      $_GET,
      $_POST,
      $_COOKIE,
      $_FILES,
      getallheaders()
    );
  }
}
