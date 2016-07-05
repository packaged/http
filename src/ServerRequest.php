<?php
namespace Packaged\Http;

use Packaged\Http\Helpers\ArrayHelper;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
  protected $server = [];
  protected $cookies = [];
  protected $query = [];
  protected $files = [];
  protected $parsedBody;
  protected $attributes = [];

  public function getServerParams()
  {
    return $this->server;
  }

  public function getCookieParams()
  {
    return $this->cookies;
  }

  public function withCookieParams(array $cookies)
  {
    $request = clone $this;
    $request->cookies = $cookies;
    return $request;
  }

  public function getQueryParams()
  {
    return $this->query;
  }

  public function withQueryParams(array $query)
  {
    $request = clone $this;
    $request->query = $query;
    return $request;
  }

  public function getUploadedFiles()
  {
    return $this->files;
  }

  public function withUploadedFiles(array $uploadedFiles)
  {
    $request = clone $this;
    $request->files = $uploadedFiles;
    return $request;
  }

  public function getParsedBody()
  {
    if($this->parsedBody instanceof StreamInterface)
    {
      return $this->parsedBody->__toString();
    }
    else
    {
      return $this->parsedBody;
    }
  }

  public function withParsedBody($data)
  {
    $request = clone $this;
    $request->parsedBody = $data;
    return $request;
  }

  public function getAttributes()
  {
    return $this->attributes;
  }

  public function getAttribute($name, $default = null)
  {
    return ArrayHelper::value($this->attributes, $name, $default);
  }

  public function withAttribute($name, $value)
  {
    $request = clone $this;
    $request->attributes[$name] = $value;
    return $request;
  }

  public function withoutAttribute($name)
  {
    $request = clone $this;
    unset($request->attributes[$name]);
    return $request;
  }

  public function getQuery($key, $default = null)
  {
    return ArrayHelper::value($this->query, $key, $default);
  }

  public function hasQuery($key)
  {
    return array_key_exists($key, $this->query);
  }

  public function getServerParam($key, $default = null)
  {
    return ArrayHelper::value($this->server, $key, $default);
  }

  public function hasPost($key)
  {
    return is_array($this->parsedBody)
    && array_key_exists($key, $this->parsedBody);
  }

  public function getPost($key, $default = null)
  {
    if(is_array($this->parsedBody))
    {
      return ArrayHelper::value($this->parsedBody, $key, $default);
    }
    return $default;
  }
}
