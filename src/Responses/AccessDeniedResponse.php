<?php
namespace Packaged\Http\Responses;

use Packaged\Http\Response;

class AccessDeniedResponse extends Response
{
  public function __construct($content = 'Access Denied', int $status = 403, array $headers = [])
  {
    parent::__construct($content, $status, $headers);
  }
}
