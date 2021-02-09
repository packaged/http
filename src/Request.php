<?php
namespace Packaged\Http;

use Packaged\Http\Interfaces\RequestMethod;
use Packaged\Map\ArrayDataMap;
use Packaged\Map\DataMap;

class Request extends HttpMessage
{
  protected $_method = RequestMethod::GET;
  protected $_uri = '/';

  /**
   * @var DataMap
   */
  protected $_files;
  /**
   * @var DataMap
   */
  protected $_query;
  /**
   * @var DataMap
   */
  protected $_post;

  protected $_body;

  public function __construct(
    string $method, string $uri, array $query = [], array $post = [], array $cookies = [],
    array $files = [], array $headers = [], $body = ''
  )
  {
    $this->_method = $method;
    $this->_uri = $uri;
    $this->_headers = new ArrayDataMap($headers);
    $this->_query = new DataMap($query);
    $this->_post = new DataMap($post);
    $this->_files = new DataMap($files);
    $this->_body = $body;
  }

  public static function createFromGlobals()
  {
    [$uri,] = explode('?', $_SERVER['REQUEST_URI'], 2);
    return new static(
      $_SERVER['REQUEST_METHOD'],
      $uri,
      $_GET,
      $_POST,
      $_COOKIE,
      $_FILES,
      getallheaders()
    );
  }
}
