<?php
namespace Packaged\Http\LinkBuilder;

use Packaged\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LinkBuilder
{
  protected $_scheme;
  protected $_subDomain;
  protected $_domain;
  protected $_tld;
  protected $_port;
  protected $_path;
  protected $_fragment;
  protected $_query = [];
  /**
   * @var Request
   */
  protected $_request;

  public static function fromRequest(Request $request, $path = '', $query = [])
  {
    $lb = new static();
    $lb->_request = $request;
    $lb->_path = $path === null ? $request->path() : $path;
    $lb->_query = $query === null ? $request->query->all() : $query;
    return $lb;
  }

  public function __toString()
  {
    return $this->asUrl();
  }

  public function asUrl(): string
  {
    $scheme = $this->_scheme ?? ($this->_request->isSecure(true) ? 'https' : 'http');
    $port = $this->_port ?? $this->_request->port();
    return
      ($scheme . '://') . implode(
        '.',
        [
          ($this->_subDomain ?? $this->_request->subDomain()),
          ($this->_domain ?? $this->_request->domain()),
          ($this->_tld ?? $this->_request->tld()),
        ]
      )
      . ($this->_isStandardPort($this->_scheme ?? $this->_request->getScheme(), $port) ? '' : ':' . $port)
      . (isset($this->_path[0]) && $this->_path[0] !== '/' ? '/' : '')
      . $this->_path
      . (!empty($this->_query) ? '?' . http_build_query($this->_query) : null)
      . ($this->_fragment ? '#' . $this->_fragment : null);
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

  /**
   * @param array $queryParams
   *
   * @return $this
   */
  public function setQuery(array $queryParams)
  {
    $this->_query = $queryParams;
    return $this;
  }

  /**
   * @param $key
   * @param $value
   *
   * @return $this
   */
  public function addQuery($key, $value)
  {
    $this->_query[$key] = $value;
    return $this;
  }

  /**
   * @return string
   */
  public function getFragment()
  {
    return $this->_fragment;
  }

  /**
   * @param string $fragment
   *
   * @return LinkBuilder
   */
  public function setFragment(string $fragment)
  {
    $this->_fragment = ltrim($fragment, '#');
    return $this;
  }

  public function toRedirect($status = 307, $headers = [])
  {
    return RedirectResponse::create($this->asUrl(), $status, $headers);
  }
}
