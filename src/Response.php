<?php
namespace Packaged\Http;

use Packaged\Http\Helpers\ResponseHelper;
use Psr\Http\Message\ResponseInterface;

class Response extends HttpMessage implements ResponseInterface
{
  protected $status = 200;
  protected $reason = 'OK';

  public function getStatusCode()
  {
    return $this->status;
  }

  public function withStatus($code, $reasonPhrase = '')
  {
    $response = clone $this;
    $response->status = ResponseHelper::validateStatusCode($code);
    if(empty($reasonPhrase))
    {
      $response->reason = ResponseHelper::getReasonPhrase($response->status);
    }
    else
    {
      $response->reason = $reasonPhrase;
    }
    return $response;
  }

  public function getReasonPhrase()
  {
    return $this->reason;
  }

}
