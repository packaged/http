<?php
namespace Packaged\Http\Streams;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
  const MODE_READONLY = 'r';
  const MODE_READ_WRITE_START = 'r+';
  const MODE_WRITE_TRUNCATE = 'w';
  const MODE_READ_REPLACE = 'w+';
  const MODE_APPEND = 'a';
  const MODE_READ_APPEND = 'a+';
  const MODE_WRITE_NEW = 'x';
  const MODE_READ_WRITE_NEW = 'x+';
  const MODE_WRITE = 'c';
  const MODE_READ_WRITE = 'c+';

  protected $resource;
  protected $stream;

  public function __toString()
  {
    if($this->isReadable())
    {
      try
      {
        $this->rewind();

        return $this->getContents();
      }
      catch(\Exception $e)
      {
        return (string)$e;
      }
    }
    return '';
  }

  public function attach($stream, $mode = self::MODE_READONLY)
  {
    $this->stream = $stream;

    if(is_resource($stream))
    {
      $this->resource = $stream;
    }
    else if(is_string($stream))
    {
      $this->resource = fopen($stream, $mode);
    }
    else
    {
      throw new \InvalidArgumentException('Invalid resource.');
    }

    return $this;
  }

  public function close()
  {
    if($this->resource)
    {
      $resource = $this->detach();
      fclose($resource);
    }
  }

  public function detach()
  {
    $resource = $this->resource;

    $this->resource = null;
    $this->stream = null;

    return $resource;
  }

  public function getSize()
  {
    if(!is_resource($this->resource))
    {
      return null;
    }

    $stats = fstat($this->resource);

    return $stats['size'];
  }

  public function tell()
  {
    $this->checkResource();

    $position = ftell($this->resource);

    if(!is_int($position))
    {
      throw new \RuntimeException('No data available during ftell');
    }

    return $position;
  }

  public function eof()
  {
    if(is_resource($this->resource))
    {
      return feof($this->resource);
    }
    return true;
  }

  public function isSeekable()
  {
    if(is_resource($this->resource))
    {
      $meta = stream_get_meta_data($this->resource);
      return $meta['seekable'];
    }
    return false;
  }

  public function seek($offset, $whence = SEEK_SET)
  {
    $this->checkResource();

    if(!$this->isSeekable())
    {
      throw new \RuntimeException('Stream is not seekable');
    }

    $result = fseek($this->resource, $offset, $whence);

    if($result !== 0)
    {
      throw new \RuntimeException('Error seeking within stream');
    }

    return true;
  }

  public function rewind()
  {
    return $this->seek(0);
  }

  public function isWritable()
  {
    $this->checkResource();

    $meta = stream_get_meta_data($this->resource);
    return is_writable($meta['uri']);
  }

  public function write($string)
  {
    $this->checkResource();

    $result = fwrite($this->resource, $string);

    if($result === false)
    {
      throw new \RuntimeException('Error writing to stream');
    }

    return $result;
  }

  public function isReadable()
  {
    $this->checkResource();

    $meta = stream_get_meta_data($this->resource);
    $mode = $meta['mode'];

    return (strstr($mode, self::MODE_READONLY) || strstr($mode, '+'));
  }

  public function read($length)
  {
    $this->checkResource();

    if(!$this->isReadable())
    {
      throw new \RuntimeException('Stream is not readable');
    }

    $result = fread($this->resource, $length);

    if($result === false)
    {
      throw new \RuntimeException('Error reading stream');
    }

    return $result;
  }

  public function getContents()
  {
    if(!$this->isReadable())
    {
      return '';
    }

    $result = stream_get_contents($this->resource);

    if($result === false)
    {
      throw new \RuntimeException('Error reading from stream');
    }

    return $result;
  }

  public function getMetadata($key = null)
  {
    $metadata = stream_get_meta_data($this->resource);

    if($key === null)
    {
      return $metadata;
    }

    return array_key_exists($key, $metadata) ? $metadata[$key] : null;
  }

  protected function checkResource()
  {
    if(!is_resource($this->resource))
    {
      throw new \RuntimeException('No Resource Available');
    }
  }

}
