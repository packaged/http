<?php
namespace Packaged\Http\Streams;

class PhpTempStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://temp', $mode);
  }
}
