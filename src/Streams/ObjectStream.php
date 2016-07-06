<?php
namespace Packaged\Http\Streams;

class ObjectStream extends StringStream
{
  const OUTPUT_JSON = 'json';
  const OUTPUT_JSON_PRETTY = 'json.pretty';
  const OUTPUT_SERIALIZE = 'serialize';
  const OUTPUT_PRINTR = 'printr';
  const OUTPUT_VARDUMP = 'vardump';

  protected $output = self::OUTPUT_JSON;

  public function setOutputMode($mode)
  {
    $this->output = $mode;
    return $this;
  }

  public function attach($stream, $mode = self::MODE_READ_WRITE)
  {
    if(!is_object($stream))
    {
      throw new \InvalidArgumentException(
        'ObjectStream does not support non object input.'
      );
    }

    $this->stream = $stream;

    if(strpos('+', $mode) === false)
    {
      $this->writable = false;
    }

    return $this;
  }

  public function write($string)
  {
    $this->resource = $string;
    $this->position = strlen($this->resource);
    return $this->position;
  }

  protected function prepareResource()
  {
    switch($this->output)
    {
      case self::OUTPUT_JSON:
        $this->write(json_encode($this->stream));
        break;
      case self::OUTPUT_JSON_PRETTY:
        $this->write(json_encode($this->stream, JSON_PRETTY_PRINT));
        break;
      case self::OUTPUT_SERIALIZE:
        $this->write(serialize($this->stream));
        break;
      case self::OUTPUT_PRINTR:
        $this->write(print_r($this->stream, true));
        break;
      case self::OUTPUT_VARDUMP:
        $this->write(var_export($this->stream, true));
        break;
    }
    return $this->resource;
  }
}
