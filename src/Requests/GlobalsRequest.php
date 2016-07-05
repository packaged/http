<?php
namespace Packaged\Http\Requests;

use Packaged\Http\Helpers\ArrayHelper;
use Packaged\Http\Request;
use Packaged\Http\Streams\PhpInputStream;
use Packaged\Http\Uris\GlobalsUri;

class GlobalsRequest extends Request
{
  public function __construct()
  {
    $this->body = new PhpInputStream();
    $this->method = ArrayHelper::value($_SERVER, 'REQUEST_METHOD', 'GET');
    $this->protocol = stristr(
      ArrayHelper::value($_SERVER, 'SERVER_PROTOCOL'),
      '1.1'
    ) ? '1.1' : '1.0';

    foreach(getallheaders() as $header => $value)
    {
      $this->addHeader($header, $value);
    }

    $this->uri = new GlobalsUri();
  }
}
