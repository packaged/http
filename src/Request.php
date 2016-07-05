<?php
namespace Packaged\Http;

use Packaged\Http\Helpers\RequestHelper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends HttpMessage implements RequestInterface
{
  /**
   * @var UriInterface
   */
  protected $uri;
  protected $target;
  protected $method;

  public function getRequestTarget()
  {
    return $this->target;
  }

  public function withRequestTarget($requestTarget)
  {
    $request = clone $this;
    $request->target = $requestTarget;
    return $request;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function withMethod($method)
  {
    $method = RequestHelper::validateMethod($method);
    $request = clone $this;
    $request->method = $method;
    return $request;
  }

  public function getUri()
  {
    return $this->uri;
  }

  public function withUri(UriInterface $uri, $preserveHost = false)
  {
    $request = clone $this;
    $request->uri = $uri;

    if($preserveHost || !$uri->getHost())
    {
      return $request;
    }

    $host = $uri->getHost();

    if($uri->getPort())
    {
      $host .= ':' . $uri->getPort();
    }

    $request->withHeader('host', $host);

    return $request;
  }
}
