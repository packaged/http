<?php
namespace Packaged\Http\Streams;

class FileStream extends Stream
{
  public function __construct($file, $mode = self::MODE_READ_WRITE)
  {
    $this->attach($file, $mode);
  }
}
