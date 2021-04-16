<?php
namespace Packaged\Http;

use Packaged\Http\Interfaces\ResponseStatus;
use Packaged\Map\ArrayDataMap;

class Response extends HttpMessage
{
  protected $_statusCode;
  protected $_content;

  public function __construct($content = '', $statusCode = ResponseStatus::OK, $headers = [])
  {
    $this->_statusCode = $statusCode;
    $this->_content = $content;
    $this->_headers = new ArrayDataMap($headers);
  }

  public static function create($content = '', $status = ResponseStatus::OK, $headers = [])
  {
    return new static($content, $status, $headers);
  }

  public function __toString()
  {
    return
      //StartLine
      //$this->_startLine()
      ''
      . "\r\n"
      //Headers
      . $this->_headersString()
      . "\r\n"
      //Content
      . $this->getContent();
  }

  public function sendHeaders()
  {
    header(
      sprintf('HTTP/%s %s %s', $this->_httpVersion, $this->_statusCode, ResponseStatus::PHRASES[$this->_statusCode])
    );
    foreach($this->headers()->all() as $name => $values)
    {
      $name = ucwords($name, '-');
      foreach((array)$values as $value)
      {
        header(sprintf("%s %s\r\n", $name . ':', $value));
      }
    }
  }

  public function getContent()
  {
    return $this->_content;
  }

  /**
   * Is the response a redirect of some form?
   *
   * @final
   */
  public function isRedirect(string $location = null): bool
  {
    return \in_array($this->_statusCode, [201, 301, 302, 303, 307, 308])
      && null === $location || $location == $this->headers()->get('Location');
  }
}
