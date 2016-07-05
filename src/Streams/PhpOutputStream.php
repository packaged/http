<?php
namespace Packaged\Http\Streams;

class PhpOutputStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://output', $mode);
  }
}
