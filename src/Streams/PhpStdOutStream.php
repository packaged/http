<?php
namespace Packaged\Http\Streams;

class PhpStdOutStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://stdout', $mode);
  }
}
