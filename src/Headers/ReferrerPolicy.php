<?php
namespace Packaged\Http\Headers;

class ReferrerPolicy implements Header
{
  public function getKey(): string
  {
    return 'referrer-policy';
  }

  public function getValue()
  {
    return 'strict-origin';
  }
}
