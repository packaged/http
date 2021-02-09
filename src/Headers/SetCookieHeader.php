<?php
namespace Packaged\Http\Headers;

use Packaged\Http\Cookies\Cookie;

class SetCookieHeader implements Header
{
  /** @var Cookie */
  protected $_cookie;

  public function getKey(): string
  {
    return 'set-cookie';
  }

  public function getValue()
  {
    return $this->_cookie->toHeaderValue();
  }

  public function setCookie(Cookie $cookie)
  {
    $this->_cookie = $cookie;
    return $this;
  }

  public static function withCookie(Cookie $cookie): self
  {
    return (new static())->setCookie($cookie);
  }
}
