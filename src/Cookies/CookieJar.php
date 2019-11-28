<?php

namespace Packaged\Http\Cookies;

use Packaged\Config\ConfigurableInterface;
use Packaged\Config\ConfigurableTrait;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CookieJar implements ConfigurableInterface
{
  use ConfigurableTrait;

  /**
   * @var CookieHandler[]
   */
  protected $_handlers = [];

  /**
   * @var Cookie[]
   */
  protected $_responseCookies = [];
  /**
   * @var string[]
   */
  protected $_requestCookies = [];
  protected $_deleteCookies = [];

  public function __construct()
  {
    $this->_handlers[1000] = new DefaultHandler();
  }

  /**
   * @param CookieHandler $handler
   * @param int           $priority
   * @param bool          $replace
   *
   * @return $this
   * @throws \Exception
   */
  public function addHandler(CookieHandler $handler, int $priority = 10, bool $replace = false)
  {
    if(isset($this->_handlers[$priority]) && !$replace)
    {
      throw new \Exception("A cookie handler already exists with priority " . $priority);
    }
    $this->_handlers[$priority] = $handler;
    return $this;
  }

  protected function _getHandler($name, $value): CookieHandler
  {
    foreach($this->_handlers as $handler)
    {
      if($handler->canHandle($name, $value))
      {
        return $handler;
      }
    }
  }

  public function hydrate(Request $request)
  {
    foreach($request->cookies->all() as $name => $cookie)
    {
      $handler = $this->_getHandler($name, $cookie);
      $this->_requestCookies[$handler->decodeName($name)] = $handler->decodeValue($cookie);
    }
  }

  public function read(string $name, bool $checkQueued = false)
  {
    return $this->_requestCookies[$name] ??
      ($checkQueued && isset($this->_responseCookies[$name]) ? $this->_responseCookies[$name]['v'] : null);
  }

  public function has(string $name): bool
  {
    return isset($this->_requestCookies[$name]) || isset($this->_responseCookies[$name]);
  }

  public function store(string $name, string $value = null, $expireSeconds = 0)
  {
    unset($this->_deleteCookies[$name]);
    $this->_responseCookies[$name] = ['v' => $value, 'e' => $expireSeconds > 0 ? (time() + $expireSeconds) : 0];
    return $this;
  }

  public function delete(string $name)
  {
    unset($this->_responseCookies[$name], $this->_requestCookies[$name]);
    $this->_deleteCookies[$name] = $name;
    return $this;
  }

  /**
   * Apply cookies to a response object
   *
   * @param Response $response
   *
   * @return Response
   * @throws \Exception
   */
  public function applyToResponse(Response $response): Response
  {
    $domain = $this->_config()->getItem("domain");
    $secure = $this->_config()->getItem("secure_only", null);

    //Write cookies
    foreach($this->_responseCookies as $name => $rc)
    {
      $handler = $this->_getHandler($name, $rc['v']);
      $response->headers->setCookie(
        Cookie::create(
          $handler->encodeName($name),
          $handler->encodeValue($rc['v']),
          $rc['e'],
          null,
          $domain,
          $secure,
          true,
          false
        )
      );
    }

    //Delete Cookies
    foreach($this->_deleteCookies as $cookieName)
    {
      $handler = $this->_getHandler($cookieName, null);
      $response->headers->setCookie(Cookie::create($handler->encodeName($cookieName), null, '-2628000', null, $domain));
    }

    return $response;
  }
}
