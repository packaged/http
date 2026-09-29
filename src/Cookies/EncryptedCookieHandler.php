<?php
namespace Packaged\Http\Cookies;

use Packaged\Http\Encryption\DecryptException;
use Packaged\Http\Encryption\EncrypterInterface;

/**
 * Encrypts cookie values. A request cookie that does not decrypt, because it was tampered with or encrypted
 * with a key that is no longer configured, is left out of the CookieJar.
 *
 *   $jar->addHandler(new EncryptedCookieHandler(Encrypter::fromConfig($config)));
 */
class EncryptedCookieHandler extends AbstractCookieHandler
{
  protected EncrypterInterface $_encrypter;
  /**
   * @var string[] names of cookies stored as plain text, e.g. cookies read by client-side scripts
   */
  protected array $_plainTextCookies;

  public function __construct(EncrypterInterface $encrypter, array $plainTextCookies = [])
  {
    $this->_encrypter = $encrypter;
    $this->_plainTextCookies = $plainTextCookies;
  }

  public function canHandle(string $name, $value = null): bool
  {
    return !in_array($name, $this->_plainTextCookies, true);
  }

  public function decodeValue(string $value): string
  {
    try
    {
      return $this->_encrypter->decrypt($value);
    }
    catch(DecryptException $e)
    {
      throw new InvalidCookieException($e->getMessage(), 0, $e);
    }
  }

  public function encodeValue(string $value): string
  {
    return $this->_encrypter->encrypt($value);
  }
}
