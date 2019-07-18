<?php
namespace Packaged\Http\Headers;

class XFrameOptions implements Header
{
  public function getKey(): string
  {
    return 'x-frame-options';
  }

  public function getValue()
  {
    return 'SAMEORIGIN';
  }
}
