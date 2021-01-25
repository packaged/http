<?php
namespace Packaged\Http\Headers;

class ServerTiming implements Header
{
  protected $_timings = [];

  public static function single($key, $duration, $description = "")
  {
    $h = new static();
    $h->add($key, $duration, $description);
    return $h;
  }

  public function add($key, $duration, $description = "")
  {
    $this->_timings[$key] = "$key"
      . ($duration !== null ? ";dur=$duration" : '')
      . ($description !== null ? ";desc=\"$description\"" : '');
    return $this;
  }

  public function hasTimings()
  {
    return !empty($this->_timings);
  }

  public function getKey(): string
  {
    return 'Server-Timing';
  }

  public function getValue()
  {
    return implode(', ', $this->_timings);
  }

}
