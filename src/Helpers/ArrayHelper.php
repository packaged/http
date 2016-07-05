<?php
namespace Packaged\Http\Helpers;

class ArrayHelper
{
  public static function value($array, $key, $default = null)
  {
    if(array_key_exists($key, $array))
    {
      return $array[$key];
    }
    return $default;
  }
}
