<?php
namespace Packaged\Http;

use Packaged\Map\ArrayDataMap;

class HttpMessage
{
  const VERSION_1_0 = "1.0";
  const VERSION_1_1 = "1.1";

  protected $_httpVersion = self::VERSION_1_1;

  /** @var array|ArrayDataMap|null */
  protected $_headers;

  protected $_body;

  public function headers(): ArrayDataMap
  {
    return $this->_headers;
  }

  protected function _headersString(): string
  {
    if(!isset($this->_headers))
    {
      return '';
    }

    $return = '';
    foreach($this->_headers->all() as $name => $values)
    {
      $name = ucwords($name, '-');
      foreach((array)$values as $value)
      {
        $return .= sprintf("%s %s\r\n", $name . ':', $value);
      }
    }
    return $return;
  }
}
