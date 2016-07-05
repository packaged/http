<?php
namespace Packaged\Http\Streams;

class ResourceStream extends Stream
{
  public function __construct($resource)
  {
    $this->attach($resource);
  }
}
