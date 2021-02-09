<?php
namespace Packaged\Http\Headers;

class HeaderValidator
{
  public static function assertName(string $name)
  {
    if(!preg_match('/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/', $name))
    {
      throw new \InvalidArgumentException(sprintf("%s is not a valid header name", $name));
    }
    return true;
  }
}
