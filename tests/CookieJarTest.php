<?php

namespace Packaged\Tests\Http;

use Packaged\Helpers\Objects;
use Packaged\Http\Cookies\CookieJar;
use Packaged\Http\Cookies\LowercaseCookieHandler;
use Packaged\Http\Request;
use Packaged\Http\Response;
use PHPUnit\Framework\TestCase;

class CookieJarTest extends TestCase
{
  public function testCrud()
  {
    $req = new Request([], [], [], ['ABC' => 'def']);
    $jar = new CookieJar();
    $jar->hydrate($req);

    self::assertEquals('def', $jar->read('ABC'));
    self::assertNull($jar->read('xyz'));
    self::assertNull($jar->read('xyz', true));
    self::assertFalse($jar->has('xyz'));
    self::assertFalse($jar->has('xyz', true));

    $jar->store('xyz', '123', 10);
    self::assertNull($jar->read('xyz'));
    self::assertEquals('123', $jar->read('xyz', true));
    self::assertFalse($jar->has('xyz'));
    self::assertTrue($jar->has('xyz', true));

    //Check for an updated value
    $jar->store('xyz', '456');
    self::assertEquals('456', $jar->read('xyz', true));

    $jar->store('ABC', 'ghi');
    self::assertEquals('def', $jar->read('ABC', false));
    self::assertEquals('ghi', $jar->read('ABC', true));

    //Check delete
    $jar->delete('xyz');
    self::assertNull($jar->read('xyz'));
    self::assertNull($jar->read('xyz', true));
  }

  public function testHandlers()
  {
    $req = new Request([], [], [], ['ABC' => 'def']);

    //Check removing all handlers will fallback to the default handler
    $jar = new CookieJar();
    self::assertTrue($jar->removeHandler(1000));
    self::assertFalse($jar->removeHandler(1000));
    $jar->hydrate($req);
    self::assertEquals('def', $jar->read('ABC'));
    self::assertNull($jar->read('abc'));

    $jar = new CookieJar();
    $jar->addHandler(new LowercaseCookieHandler(), 10, true);
    $jar->hydrate($req);
    self::assertNull($jar->read('ABC'));
    self::assertEquals('def', $jar->read('abc'));

    $this->expectExceptionMessage("A cookie handler already exists with priority 10");
    $jar->addHandler(new LowercaseCookieHandler(), 10);
  }

  public function testResponse()
  {
    $req = new Request([], [], [], ['ABC' => 'def']);
    $jar = new CookieJar();
    $jar->hydrate($req);
    $jar->store('newval', 'abc', 10);
    $jar->delete('oldval');
    $response = new Response();
    $jar->applyToResponse($response);

    $cookies = Objects::mpull($response->headers->getCookies(), 'getValue', 'getName');
    self::assertCount(2, $cookies);
    self::assertArrayHasKey('oldval', $cookies);
    self::assertArrayHasKey('newval', $cookies);
    self::assertEquals('abc', $cookies['newval']);
  }
}
