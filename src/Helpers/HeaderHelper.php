<?php
namespace Packaged\Http\Helpers;

class HeaderHelper
{
  /**
   * Check whether or not a header name is valid.
   *
   * @param   mixed $name
   *
   * @return  boolean
   *
   * @see http://tools.ietf.org/html/rfc7230#section-3.2
   */
  public static function validateName($name)
  {
    if(!preg_match('/^[a-zA-Z0-9\'`#$%&*+.^_|~!-]+$/', $name))
    {
      throw new \InvalidArgumentException("$name is not a valid header name");
    }
  }
}
