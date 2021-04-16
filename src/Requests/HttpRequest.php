<?php
namespace Packaged\Http\Requests;

use Packaged\Http\Interfaces\RequestMethod;
use Packaged\Http\Request;

class HttpRequest extends Request
{
  public static function create(
    string $uri = '/', string $method = RequestMethod::GET, array $query = [], array $post = [], array $cookies = [],
    array $files = [], array $headers = [], $body = ''
  )
  {
    return new static($uri, $method, $query, $post, $cookies, $files, $headers, $body);
  }
}
