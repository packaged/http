<?php
namespace Packaged\Http\Streams;

class PhpMemoryStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://memory', $mode);
  }
}
