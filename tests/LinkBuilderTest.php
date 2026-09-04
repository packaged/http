<?php

namespace Packaged\Tests\Http;

use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\Http\Request;
use Packaged\Http\Responses\RedirectResponse;
use PHPUnit\Framework\TestCase;

class LinkBuilderTest extends TestCase
{
  public function testAsUrl()
  {
    $request = Request::create('www.packaged.local:81/path?key=value');

    self::assertEquals(
      'http://www.packaged.local:81/path?key=value',
      LinkBuilder::fromRequest($request, null, null)->asUrl()
    );
    self::assertEquals('http://www.packaged.local:81', LinkBuilder::fromRequest($request)->asUrl());
    self::assertEquals('http://www.packaged.local:81/ab', LinkBuilder::fromRequest($request, '/ab')->asUrl());
    self::assertEquals('http://www.packaged.local', LinkBuilder::fromRequest($request)->setPort(80)->asUrl());
    self::assertEquals('http://www.packaged.local', LinkBuilder::fromRequest($request)->setPort('80')->asUrl());
    self::assertEquals('http://www.packaged.local:81', LinkBuilder::fromRequest($request)->setPort('81')->asUrl());

    $lb = LinkBuilder::fromRequest($request);
    self::assertEquals('http://www.packaged.local:81', $lb->asUrl());

    $lb->setSubDomain('secure');
    self::assertEquals('http://secure.packaged.local:81', $lb->asUrl());

    $lb->setTld('com');
    self::assertEquals('http://secure.packaged.com:81', $lb->asUrl());

    $lb->setScheme('https');
    self::assertEquals('https://secure.packaged.com:81', $lb->asUrl());

    $lb->setPath('/order');
    self::assertEquals('https://secure.packaged.com:81/order', $lb->asUrl());

    $lb->setPath('order');
    self::assertEquals('https://secure.packaged.com:81/order', $lb->asUrl());

    $lb->setDomain('cubex');
    self::assertEquals('https://secure.cubex.com:81/order', $lb->asUrl());

    $lb->setPort('443');
    self::assertEquals('https://secure.cubex.com/order', $lb->asUrl());
    self::assertEquals('https://secure.cubex.com/order', $lb);
    self::assertEquals('https://secure.cubex.com/order', $lb->__toString());
    self::assertEquals('https://secure.cubex.com/order', (string)$lb);

    $lb->addQuery('a', 'b');
    self::assertEquals('https://secure.cubex.com/order?a=b', $lb);

    $lb->addQuery('c', 'd')->addQuery('f', 'g');
    self::assertEquals('https://secure.cubex.com/order?a=b&c=d&f=g', $lb);

    $lb->addQuery('c', 'e')->addQuery('f', 'g');
    self::assertEquals('https://secure.cubex.com/order?a=b&c=e&f=g', $lb);

    $lb->setQuery(['a' => 1, 'b' => 2]);
    self::assertEquals('https://secure.cubex.com/order?a=1&b=2', $lb);

    $lb->appendPath('step');
    self::assertEquals('https://secure.cubex.com/order/step?a=1&b=2', $lb);

    $resp = $lb->toRedirect(301);
    $this->assertInstanceOf(RedirectResponse::class, $resp);
    $this->assertEquals(301, $resp->getStatusCode());

    $request = Request::create('http://www.packaged.local/');
    $request->headers->set('X_FORWARDED_PROTO', 'https');
    $this->assertFalse($request->isSecure());
    $this->assertTrue($request->isSecure(true));
    $lb = LinkBuilder::fromRequest($request);
    $lb->setSubDomain('secure');
    self::assertEquals('https://secure.packaged.local', $lb->asUrl());

    $lb->setFragment('#abc');
    self::assertEquals('abc', $lb->getFragment());
    self::assertEquals('https://secure.packaged.local#abc', $lb->asUrl());
    $lb->setFragment('def');
    self::assertEquals('https://secure.packaged.local#def', $lb->asUrl());
  }

  /**
   * Behind a TLS terminating proxy the scheme comes from X-Forwarded-Proto, so
   * 443 is the standard port and should not be written into the url
   */
  public function testAsUrlBehindTlsTerminatingProxy()
  {
    $request = Request::create('http://www.packaged.local:443/');
    $request->headers->set('X_FORWARDED_PROTO', 'https');

    self::assertFalse($request->isSecure());
    self::assertTrue($request->isSecure(true));
    self::assertEquals('http', $request->getScheme());
    self::assertEquals(443, $request->port());

    self::assertEquals('https://www.packaged.local', LinkBuilder::fromRequest($request)->asUrl());
  }
}
