<?php
namespace Packaged\Http\LinkBuilder;

use Packaged\Http\Request;

class LinkBuilder
{
  protected $_scheme;
  protected $_subDomain;
  protected $_domain;
  protected $_tld;
  protected $_port;
  protected $_path;
  /**
   * @var Request
   */
  protected $_request;

  public static function fromRequest(Request $request, $path = '')
  {
    $lb = new static();
    $lb->_request = $request;
    $lb->_path = $path === null ? $request->path() : $path;
    return $lb;
  }

  public function __toString()
  {
    return $this->asUrl();
  }

  public function asUrl(): string
  {
    $scheme = $this->_scheme ?? $this->_request->getScheme();
    $port = $this->_port ?? $this->_request->port();
    return
      ($scheme . '://')
      . implode(
        '.',
        [
          ($this->_subDomain ?? $this->_request->subDomain()),
          ($this->_domain ?? $this->_request->domain()),
          ($this->_tld ?? $this->_request->tld()),
        ]
      )
      . ($this->_isStandardPort($scheme, $port) ? '' : ':' . $port)
      . (isset($this->_path[0]) && $this->_path[0] !== '/' ? '/' : '')
      . $this->_path;
  }

  protected function _isStandardPort($scheme, $port)
  {
    return ('http' == $scheme && $port == 80) || ('https' == $scheme && $port == 443);
  }

  /**
   * @param mixed $scheme
   *
   * @return LinkBuilder
   */
  public function setScheme($scheme)
  {
    $this->_scheme = $scheme;
    return $this;
  }

  /**
   * @param mixed $subDomain
   *
   * @return LinkBuilder
   */
  public function setSubDomain($subDomain)
  {
    $this->_subDomain = $subDomain;
    return $this;
  }

  /**
   * @param mixed $domain
   *
   * @return LinkBuilder
   */
  public function setDomain($domain)
  {
    $this->_domain = $domain;
    return $this;
  }

  /**
   * @param mixed $tld
   *
   * @return LinkBuilder
   */
  public function setTld($tld)
  {
    $this->_tld = $tld;
    return $this;
  }

  /**
   * @param mixed $port
   *
   * @return LinkBuilder
   */
  public function setPort($port)
  {
    $this->_port = $port;
    return $this;
  }

  /**
   * @param mixed $path
   *
   * @return LinkBuilder
   */
  public function setPath($path)
  {
    $this->_path = $path;
    return $this;
  }
}