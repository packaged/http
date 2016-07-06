<?php
namespace Packaged\Http\Streams;

class StringStream extends Stream
{
  protected $position = 0;
  protected $seekable = true;
  protected $writable = true;

  public function __construct($stream = '', $mode = self::MODE_READ_WRITE)
  {
    $this->attach($stream, $mode);
  }

  public function close()
  {
    $this->detach();
  }

  public function attach($stream, $mode = self::MODE_READ_WRITE)
  {
    if(!is_string($stream))
    {
      throw new \InvalidArgumentException(
        'StringStream does not support non string input.'
      );
    }

    $this->resource = $this->stream = $stream;
    $this->writable = stristr($mode, '+');

    return $this;
  }

  public function detach()
  {
    $resource = $this->resource;
    $this->resource = $this->stream = null;
    $this->position = 0;
    $this->seekable = true;
    $this->writable = true;

    return $resource;
  }

  public function getSize()
  {
    $this->prepareResource();
    return $this->resource === null ? null : strlen($this->resource);
  }

  public function tell()
  {
    $this->checkResource();

    return $this->position;
  }

  public function eof()
  {
    return $this->position == $this->getSize();
  }

  public function isSeekable()
  {
    return $this->seekable;
  }

  public function seek($offset, $whence = SEEK_SET)
  {
    if(!$this->isSeekable())
    {
      throw new \RuntimeException('Stream is not seekable');
    }

    if($whence == SEEK_SET)
    {
      $this->position = $offset;
    }
    else if($whence == SEEK_CUR)
    {
      $this->position += $offset;
    }
    else if($whence == SEEK_END)
    {
      $this->position = $this->getSize() + $offset;
    }

    if($this->position < 0)
    {
      throw new \RuntimeException('Position should not less than 0');
    }

    return true;
  }

  public function rewind()
  {
    return $this->seek(0);
  }

  public function isWritable()
  {
    return $this->writable;
  }

  public function write($string)
  {
    $this->resource .= $string;
    $this->position = strlen($this->resource);
    return strlen($string);
  }

  public function isReadable()
  {
    return true;
  }

  protected function prepareResource()
  {
    return $this;
  }

  public function read($length)
  {
    $this->prepareResource();
    $result = substr($this->resource, $this->position, $length);

    $this->position += $length;

    return $result;
  }

  public function getContents()
  {
    $this->prepareResource();
    $result = false;
    if($this->resource !== null)
    {
      $result = substr($this->resource, $this->position);
    }

    return $result === false ? '' : $result;
  }

  public function getMetadata($key = null)
  {
    $metadata = [
      'wrapper_type' => 'string',
      'stream_type'  => 'STDIO',
      'mode'         => $this->isWritable() ?
        self::MODE_READ_WRITE_START : self::MODE_READONLY,
      'unread_bytes' => $this->getSize() - $this->position,
      'seekable'     => $this->isSeekable(),
      'uri'          => '',
      'timed_out'    => false,
      'blocked'      => true,
      'eof'          => $this->eof(),
    ];

    if($key === null)
    {
      return $metadata;
    }

    return array_key_exists($key, $metadata) ? $metadata[$key] : null;
  }
}
