<?php
namespace Packaged\Http;

use Packaged\Http\Helpers\ResponseHelper;
use Packaged\Http\Streams\ObjectStream;
use Packaged\Http\Streams\StringStream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends HttpMessage implements ResponseInterface
{
  protected $status = 200;
  protected $reason = 'OK';

  public function __construct($body, $code = 200, $reason = null)
  {
    if($body instanceof StreamInterface)
    {
      $this->setBody($body);
    }
    else if(is_object($body))
    {
      $this->setBody(new ObjectStream($body));
    }
    else if(is_string($body))
    {
      $this->setBody(new StringStream($body));
    }
    $this->setStatus($code, $reason);
  }

  public function getStatusCode()
  {
    return $this->status;
  }

  protected function setStatus($code, $reasonPhrase = '')
  {
    $this->status = ResponseHelper::validateStatusCode($code);
    if(empty($reasonPhrase))
    {
      $this->reason = ResponseHelper::getReasonPhrase($this->status);
    }
    else
    {
      $this->reason = $reasonPhrase;
    }
    return $this;
  }

  public function withStatus($code, $reasonPhrase = '')
  {
    $response = clone $this;
    $response->setStatus($code, $reasonPhrase);
    return $response;
  }

  public function getReasonPhrase()
  {
    return $this->reason;
  }

}
