<?php
namespace Packaged\Http\Headers;

class XContentTypeOptions implements Header
{
  public function getKey(): string
  {
    return 'x-content-type-options';
  }

  public function getValue()
  {
    return 'nosniff';
  }

}
