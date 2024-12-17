<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class BoolResponse extends Response
{
  public static function create($bool = true, int $status = 200, array $headers = []): static
  {
    return parent::create($bool ? 'true' : 'false', $status, $headers);
  }
}
