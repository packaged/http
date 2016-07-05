<?php
namespace Packaged\Http;

use Packaged\Http\Streams\FileStream;
use Packaged\Http\Streams\ResourceStream;
use Packaged\Http\Streams\Stream;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
  protected $filePath;
  /**
   * @var StreamInterface
   */
  protected $stream;
  protected $size;
  protected $error;
  protected $type;
  protected $name;

  public function __construct(
    $file, $size = 0, $error = UPLOAD_ERR_OK, $filename = null, $type = null
  )
  {
    $this->size = $size;
    $this->error = $error;
    $this->name = $filename;
    $this->type = $type;

    if(is_string($file))
    {
      $this->filePath = $file;
      $this->stream = new FileStream($file, Stream::MODE_READONLY);
    }
    elseif(is_resource($file))
    {
      $this->stream = new ResourceStream($file);
    }
    elseif($file instanceof StreamInterface)
    {
      $this->stream = $file;
    }
  }

  public function getStream()
  {
    return $this->stream;
  }

  public function moveTo($targetPath)
  {
    if(!PHP_SAPI || PHP_SAPI == 'cli')
    {
      $handle = fopen($targetPath, Stream::MODE_READ_REPLACE);

      if($handle === false)
      {
        throw new \RuntimeException('Unable to write to: ' . $targetPath);
      }

      $this->stream->rewind();

      while(!$this->stream->eof())
      {
        fwrite($handle, $this->stream->read(4096));
      }

      fclose($handle);
    }
    else
    {
      if(move_uploaded_file($this->filePath, $targetPath) === false)
      {
        throw new \RuntimeException('Error moving uploaded file');
      }
    }
  }

  public function getSize()
  {
    return $this->size;
  }

  public function getError()
  {
    return $this->error;
  }

  public function getClientFilename()
  {
    return $this->name;
  }

  public function getClientMediaType()
  {
    return $this->type;
  }

}
