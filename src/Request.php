<?php
namespace Packaged\Http;

use Packaged\Helpers\FQDN;
use Packaged\Http\Files\RequestFiles;
use Packaged\Http\Interfaces\RequestMethod;
use Packaged\Map\ArrayDataMap;
use Packaged\Map\DataMap;

class Request extends HttpMessage
{
  protected $_method = RequestMethod::GET;
  protected $_uri = '/';

  /** @var array|DataMap|null */
  protected $_files;
  /** @var array|DataMap|null */
  protected $_query;
  /** @var array|DataMap|null */
  protected $_post;

  protected $_body;

  protected function __construct(
    string $method = RequestMethod::GET, string $uri = '/', array $query = [], array $post = [], array $cookies = [],
    array $files = [], array $headers = [], $body = ''
  )
  {
    $this->_method = $method;
    $this->_uri = $uri;
    $this->_headers = new ArrayDataMap($headers);
    $this->_query = new DataMap($query);
    $this->_post = new DataMap($post);
    $this->_files = new RequestFiles($files);
    $this->_body = $body;
  }

  protected $_trustedProxies = [];

  public function addTrustedProxy($ip)
  {
    $this->_trustedProxies[] = $ip;
    return $this;
  }

  protected $_trustedHeaders;

  protected function _isTrustedHeader(string $header): bool
  {
    if(!isset($this->_trustedHeaders))
    {
      $this->_trustedHeaders = [];

      if($this->_isTrustedProxy())
      {

      }
    }
    return array_key_exists($header, $this->_trustedHeaders);
  }

  protected $_trustedProxy;

  protected function _isTrustedProxy(): bool
  {
    if(!isset($this->_trustedProxy) && !empty($this->_trustedProxies))
    {
      $ip = $this->headers()->get('REMOTE_ADDR');
      foreach($this->_trustedProxies as $tp)
      {
        if($ip === $tp)
        {
          $this->_trustedProxy = true;
          break;
        }
      }
    }
    return $this->_trustedProxy;
  }

  /**
   * @var FQDN
   */
  protected $_fqdn;

  /**
   * Retrieve the fully qualified domain name
   *
   * @return FQDN
   */
  public function getFqdn(): FQDN
  {
    if($this->_fqdn === null)
    {
      $this->_fqdn = new FQDN($this->getHost());
    }
    return $this->_fqdn;
  }

  protected $_host;
  protected $_port;

  public function getHost(): string
  {
    if(!isset($this->_host))
    {
      $headers = $this->headers();
      //check trusted proxy & value
      $this->_host = $headers->get('HOST') ?: ($headers->get('SERVER_NAME') ?: $headers->get('SERVER_ADDR', ''));

      $portPos = strrpos($this->_host, ':');
      if($portPos !== false)
      {
        $this->_port = (int)substr($this->_host, $portPos + 1);
        $this->_host = substr($this->_host, 0, $portPos);
      }
    }
    return $this->_host;
  }

  public function getPort(): int
  {
    if(!isset($this->_port))
    {
      //Calculate get host
      $this->getHost();
      if($this->_port < 1)
      {
        $this->_port = $this->isSecure() ? 443 : 80;
      }
    }
    return $this->_port;
  }

  protected $_isSecure;

  public function isSecure(): bool
  {
    if(!isset($this->_isSecure))
    {
      $this->_isSecure = false;
    }
    return $this->_isSecure;
  }

  public function query(): DataMap
  {
    return $this->_query;
  }

  public function post(): DataMap
  {
    return $this->_post;
  }

  public function files(): RequestFiles
  {
    return $this->_files;
  }
}
