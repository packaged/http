<?php
namespace Packaged\Http\Streams;

class PhpStdErrStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://stderr', $mode);
  }
}
