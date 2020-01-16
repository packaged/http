<?php

namespace Packaged\Tests\Http;

use Packaged\Http\LinkBuilder\LinkBuilder;
use Packaged\Http\Request;
use PHPUnit\Framework\TestCase;

class LinkBuilderTest extends TestCase
{

  public function testAsUrl()
  {
    $request = Request::createFromGlobals();
    $request->headers->set('HOST', 'www.packaged.local:81');
    $request->server->set('REQUEST_URI', '/path');

    self::assertEquals('http://www.packaged.local:81', LinkBuilder::fromRequest($request)->asUrl());
    self::assertEquals('http://www.packaged.local:81/ab', LinkBuilder::fromRequest($request, '/ab')->asUrl());
    self::assertEquals('http://www.packaged.local', LinkBuilder::fromRequest($request)->setPort(80)->asUrl());

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
  }
}