<?php
namespace Packaged\Http\Streams;

class PhpInputStream extends Stream
{
  public function __construct($mode = self::MODE_READ_WRITE)
  {
    $this->attach('php://input', $mode);
  }
}
