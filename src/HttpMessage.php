<?php
namespace Packaged\Http;

use Packaged\Http\Helpers\HeaderHelper;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class HttpMessage implements MessageInterface
{
  protected $protocol = "1.1";
  protected $headers = [];
  protected $body;

  public function getProtocolVersion()
  {
    return $this->protocol;
  }

  public function withProtocolVersion($version)
  {
    $message = clone $this;
    if(in_array($version, ['1.0', '1.1']))
    {
      $message->protocol = $version;
    }
    return $message;
  }

  public function getHeaders()
  {
    $headers = [];
    foreach($this->headers as $header)
    {
      foreach($header as $name => $value)
      {
        if(!isset($headers[$name]))
        {
          $headers[$name] = [];
        }
        $headers[$name] = array_merge($headers[$name], $value);
      }
    }
    return $headers;
  }

  public function hasHeader($name)
  {
    return array_key_exists(strtolower($name), $this->headers);
  }

  public function getHeader($name)
  {
    $name = strtolower($name);
    $headers = [];
    if(isset($this->headers[$name]))
    {
      foreach($this->headers[$name] as $header => $value)
      {
        $headers = array_merge($headers, $value);
      }
    }
    return $headers;
  }

  public function getHeaderLine($name)
  {
    return implode(', ', $this->getHeader($name));
  }

  public function withHeader($name, $value)
  {
    return $this->withoutHeader($name)->withAddedHeader($name, $value);
  }

  public function withAddedHeader($name, $value)
  {
    HeaderHelper::validateName($name);
    $message = clone $this;
    $message->addHeader($name, $value);
    return $message;
  }

  protected function addHeader($name, $value)
  {
    if(!isset($this->headers[strtolower($name)][$name]))
    {
      $this->headers[strtolower($name)][$name] = [];
    }
    $this->headers[strtolower($name)][$name] = array_merge(
      $this->headers[strtolower($name)][$name],
      (array)$value
    );
    return $this;
  }

  public function withoutHeader($name)
  {
    $message = clone $this;
    unset($message->headers[strtolower($name)]);
    return $message;
  }

  public function getBody()
  {
    return $this->body;
  }

  public function withBody(StreamInterface $body)
  {
    $message = clone $this;
    $message->body = $body;
    return $message;
  }

}
