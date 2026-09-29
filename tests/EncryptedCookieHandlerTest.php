<?php

namespace Packaged\Tests\Http;

use Packaged\Helpers\Objects;
use Packaged\Http\Cookies\CookieJar;
use Packaged\Http\Cookies\EncryptedCookieHandler;
use Packaged\Http\Cookies\InvalidCookieException;
use Packaged\Http\Encryption\Encrypter;
use Packaged\Http\Request;
use Packaged\Http\Response;
use PHPUnit\Framework\TestCase;

class EncryptedCookieHandlerTest extends TestCase
{
  const CURRENT = 'a-new-key-of-any-length-over-16';
  const OLDER = 'older-key-000002';

  protected static function _jar(array $keys, array $plainText = []): CookieJar
  {
    $jar = new CookieJar();
    $jar->addHandler(new EncryptedCookieHandler(new Encrypter($keys), $plainText));
    return $jar;
  }

  protected static function _responseCookies(CookieJar $jar): array
  {
    $response = $jar->applyToResponse(new Response());
    return Objects::mpull($response->headers->getCookies(), 'getValue', 'getName');
  }

  public function testRoundTrip()
  {
    $jar = self::_jar([self::CURRENT]);
    $jar->store('session', 'secret-value', 10);
    $cookies = self::_responseCookies($jar);
    self::assertNotSame('secret-value', $cookies['session']);

    $jar = self::_jar([self::CURRENT]);
    $jar->hydrate(new Request([], [], [], $cookies));
    self::assertSame('secret-value', $jar->read('session'));
  }

  public function testPreviousKeyDecrypts()
  {
    $old = self::_jar([self::OLDER]);
    $old->store('session', 'value');

    $jar = self::_jar([self::CURRENT, self::OLDER]);
    $jar->hydrate(new Request([], [], [], self::_responseCookies($old)));
    self::assertSame('value', $jar->read('session'));
  }

  public function testUndecryptableCookiesAreDropped()
  {
    $old = self::_jar([self::OLDER]);
    $old->store('retired', 'value');
    $cookies = self::_responseCookies($old) + ['forged' => 'not-a-payload', 'other' => 'plain'];

    $jar = self::_jar([self::CURRENT], ['other']);
    $jar->hydrate(new Request([], [], [], $cookies));
    self::assertFalse($jar->has('retired'));
    self::assertFalse($jar->has('forged'));
    self::assertSame('plain', $jar->read('other'));
  }

  public function testPlainTextCookies()
  {
    $jar = self::_jar([self::CURRENT], ['theme']);
    $jar->store('theme', 'dark');
    $jar->store('session', 'value');
    $cookies = self::_responseCookies($jar);
    self::assertSame('dark', $cookies['theme']);
    self::assertNotSame('value', $cookies['session']);
  }

  public function testDecodeValueThrowsInvalidCookie()
  {
    $handler = new EncryptedCookieHandler(new Encrypter(self::CURRENT));
    $this->expectException(InvalidCookieException::class);
    $this->expectExceptionMessage('base64url');
    $handler->decodeValue('not a payload!');
  }
}
