<?php
namespace Packaged\Http\Headers;

class StrictTransportSecurity implements Header
{
  public function getKey(): string
  {
    return 'strict-transport-security';
  }

  public function getValue()
  {
    return 'max-age=31536000; includeSubDomains; preload';
  }

}
