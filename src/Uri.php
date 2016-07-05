<?php
namespace Packaged\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
  protected $scheme;
  protected $username;
  protected $password;
  protected $host;
  protected $port;
  protected $path;
  protected $query;
  protected $fragment;

  public function getScheme()
  {
    return $this->scheme;
  }

  public function getAuthority()
  {
    $return = $this->_glue('@', [$this->getUserInfo(), $this->getHost()]);
    return $this->_glue(':', [$return, $this->getPort()]);
  }

  public function getUserInfo()
  {
    return $this->_glue(':', [$this->username, $this->password]);
  }

  public function getHost()
  {
    return $this->host;
  }

  public function getPort()
  {
    return $this->port;
  }

  public function getPath()
  {
    return $this->path;
  }

  public function getQuery()
  {
    return $this->query;
  }

  public function getFragment()
  {
    return $this->fragment;
  }

  public function withScheme($scheme)
  {
    $uri = clone $this;
    $uri->scheme = $scheme;
    return $uri;
  }

  public function withUserInfo($user, $password = null)
  {
    $uri = clone $this;
    $uri->username = $user;
    $uri->password = $password;
    return $uri;
  }

  public function withHost($host)
  {
    $uri = clone $this;
    $uri->host = $host;
    return $uri;
  }

  public function withPort($port)
  {
    $uri = clone $this;
    $uri->port = $port;
    return $uri;
  }

  public function withPath($path)
  {
    $uri = clone $this;
    $uri->path = $path;
    return $uri;
  }

  public function withQuery($query)
  {
    $uri = clone $this;
    $uri->query = $query;
    return $uri;
  }

  public function withFragment($fragment)
  {
    $uri = clone $this;
    $uri->fragment = $fragment;
    return $uri;
  }

  public function __toString()
  {
    $uri = $this->_glue('://', [$this->getScheme(), $this->getAuthority()]);
    $uri = $this->_glue('/', [$uri, ltrim($this->getPath(), '/')]);
    $uri = $this->_glue('?', [$uri, ltrim($this->getQuery(), '?')]);
    $uri = $this->_glue('#', [$uri, ltrim($this->getFragment(), '#')]);
    return $uri;
  }

  private function _glue($glue, $elements)
  {
    return implode($glue, array_filter($elements));
  }

}
