<?php

namespace Packaged\Http\Cookies;

class DefaultHandler extends AbstractCookieHandler
{
  public function canHandle(string $name, string $value = null): bool
  {
    return true;
  }

  public function decodeName(string $name): string
  {
    return $name;
  }

  public function encodeName(string $name): string
  {
    return $name;
  }

  public function decodeValue(string $value): string
  {
    return $value;
  }

  public function encodeValue(string $value): string
  {
    return $value;
  }

}
