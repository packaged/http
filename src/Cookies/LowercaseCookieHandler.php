<?php

namespace Packaged\Http\Cookies;

class LowercaseCookieHandler extends AbstractCookieHandler
{
  public function decodeName(string $name): string
  {
    return parent::decodeName(strtolower($name));
  }

  public function encodeName(string $name): string
  {
    return parent::encodeName(strtolower($name));
  }

}
