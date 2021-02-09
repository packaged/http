<?php
namespace Packaged\Http\Cookies;

use Packaged\Http\Headers\SetCookieHeader;

class Cookie
{
  const SAMESITE_NONE = 'none';
  const SAMESITE_LAX = 'lax';
  const SAMESITE_STRICT = 'strict';

  //Ensure we always have a safe cookie name
  private $_name;
  protected $_value;
  protected $_expiresAt;
  protected $_domain;
  protected $_path;
  protected $_secure;
  protected $_httpOnly;
  protected $_sameSite;

  public static function create(
    string $name, string $value, int $expiresAt = 0, string $path = '', string $domain = '',
    bool $secure = true, bool $httpOnly = true, string $sameSite = self::SAMESITE_LAX
  ): self
  {
    $cookie = new static();

    $cookie->_setName($name);
    $cookie->assertName($cookie->_getName());
    $cookie->assertSameSite($sameSite, $secure);

    $cookie->_name = $name;
    $cookie->_value = $value;
    $cookie->_expiresAt = $expiresAt;
    $cookie->_path = $path;
    $cookie->_domain = $domain;
    $cookie->_secure = $secure;
    $cookie->_httpOnly = $httpOnly;
    $cookie->_sameSite = $sameSite;
    return $cookie;
  }

  protected function _setName(string $name)
  {
    $this->_name = str_replace(
      ['=', ',', ';', ' ', "\t", "\r", "\n", "\v", "\f"],
      ['%3D', '%2C', '%3B', '%20', '%09', '%0D', '%0A', '%0B', '%0C'],
      $name
    );
    return $this;
  }

  protected function _getName()
  {
    return $this->_name;
  }

  public function assertName(string $name)
  {
    if($name === '')
    {
      throw new \InvalidArgumentException(sprintf("Cookies must have a name provided"));
    }

    if(strpbrk($name, "=,; \t\r\n\v\f") !== false)
    {
      throw new \InvalidArgumentException(sprintf("Invalid cookie name '%s' specified", $name));
    }
  }

  public function assertSameSite(string $sameSite, bool $secureOnly)
  {
    if($sameSite === self::SAMESITE_NONE && !$secureOnly)
    {
      throw new \InvalidArgumentException('The same site attribute cannot be "none" for insecure cookies');
    }

    if(!in_array($sameSite, ['', self::SAMESITE_NONE, self::SAMESITE_LAX, self::SAMESITE_STRICT]))
    {
      throw new \InvalidArgumentException('The same site attribute must be "strict", "lax", "none" or ""');
    }
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->_getName();
  }

  /**
   * @return string
   */
  public function getValue(): string
  {
    return $this->_value;
  }

  /**
   * @return int
   */
  public function getExpiresAt(): int
  {
    return $this->_expiresAt;
  }

  /**
   * @return string
   */
  public function getDomain(): string
  {
    return $this->_domain;
  }

  /**
   * @return string
   */
  public function getPath(): string
  {
    return $this->_path;
  }

  /**
   * @return bool
   */
  public function isSecure(): bool
  {
    return $this->_secure;
  }

  /**
   * @return bool
   */
  public function getHttpOnly(): bool
  {
    return $this->_httpOnly;
  }

  /**
   * @return string
   */
  public function getSameSite(): string
  {
    return $this->_sameSite;
  }

  public function toHeader(): SetCookieHeader
  {
    return SetCookieHeader::withCookie($this);
  }

  public function toHeaderValue(): string
  {
    $headerValue = [$this->_getName() . '=' . urlencode($this->_value)];

    if($this->_expiresAt > 0)
    {
      $headerValue[] = 'expires=' . gmdate('D, d M Y H:i:s T', $this->_expiresAt);
    }
    if(empty($this->path) === false)
    {
      $headerValue[] = 'path=' . $this->path;
    }

    if(empty($this->domain) === false)
    {
      $headerValue[] = 'domain=' . $this->domain;
    }

    if($this->_secure)
    {
      $headerValue[] = 'secure';
    }

    if($this->_httpOnly)
    {
      $headerValue[] = 'httponly';
    }

    if($this->_sameSite !== '')
    {
      $headerValue[] = 'samesite=' . $this->_sameSite;
    }

    return implode('; ', $headerValue);
  }
}
