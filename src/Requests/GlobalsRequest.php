<?php
namespace Packaged\Http\Requests;

use Packaged\Http\Helpers\ArrayHelper;
use Packaged\Http\ServerRequest;
use Packaged\Http\Streams\PhpInputStream;
use Packaged\Http\UploadedFile;
use Packaged\Http\Uris\GlobalsUri;

class GlobalsRequest extends ServerRequest
{
  public function __construct()
  {
    $this->body = new PhpInputStream();
    $this->method = ArrayHelper::value($_SERVER, 'REQUEST_METHOD', 'GET');
    $protocol = ArrayHelper::value($_SERVER, 'SERVER_PROTOCOL');
    $this->protocol = stristr($protocol, '1.1') ? '1.1' : '1.0';

    foreach(getallheaders() as $header => $value)
    {
      $this->addHeader($header, $value);
    }

    $this->query = $_GET;
    $this->cookies = $_COOKIE;

    if(!empty($_POST))
    {
      $this->parsedBody = $_POST;
    }
    else
    {
      $this->parsedBody = $this->getBody();
    }

    if(!empty($_FILES))
    {
      foreach($_FILES as $file => $data)
      {
        $this->files[$file] = new UploadedFile(
          $data['tmp_name'],
          $data['size'],
          $data['error'],
          $data['name'],
          $data['type']
        );
      }
    }

    $this->uri = new GlobalsUri();
  }
}
