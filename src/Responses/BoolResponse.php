<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class BoolResponse extends Response
{
  public static function create($bool = true, $status = 200, $headers = [])
  {
    return parent::create($bool ? 'true' : 'false', $status, $headers);
  }
}
