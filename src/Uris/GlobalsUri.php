<?php
namespace Packaged\Http\Uris;

use Packaged\Http\Helpers\ArrayHelper;
use Packaged\Http\Uri;

class GlobalsUri extends Uri
{
  public function __construct()
  {
    $this->scheme = 'http';
    if(ArrayHelper::value($_SERVER, 'HTTPS', 'Off') == 'on')
    {
      $this->scheme .= 's';
    }

    $port = (int)ArrayHelper::value($_SERVER, 'SERVER_PORT', 80);
    if(!in_array($port, [80, 443]))
    {
      $this->port = $port;
    }

    $this->query = ArrayHelper::value($_SERVER, 'QUERY_STRING');
    $this->path = ArrayHelper::value($_SERVER, 'PATH_INFO');
    list($this->host,) = explode(
      ':',
      ArrayHelper::value($_SERVER, 'HTTP_HOST'),
      2
    );
  }

}
