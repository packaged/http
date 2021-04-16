<?php
namespace Packaged\Http\Requests;

use Packaged\Http\Interfaces\RequestMethod;
use Packaged\Http\Request;

class HttpRequest extends Request
{
  public static function create(
    string $method = RequestMethod::GET, string $uri = '/', array $query = [], array $post = [], array $cookies = [],
    array $files = [], array $headers = [], $body = ''
  )
  {
    return new static($method, $uri, $query, $post, $cookies, $files, $headers, $body);
  }
}
