<?php
namespace Packaged\Http\Headers;

class XXSSProtection implements Header
{
  public function getKey(): string
  {
    return 'x-xss-protection';
  }

  public function getValue()
  {
    return '1; mode=block;';
  }

}
