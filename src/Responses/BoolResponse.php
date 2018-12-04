<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class BoolResponse extends Response
{
  public static function i($bool)
  {
    return parent::create($bool ? 'true' : 'false', 200, []);
  }
}
