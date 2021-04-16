<?php
namespace Packaged\Http;

use Packaged\Http\Headers\Header;
use Packaged\Http\Headers\ServerTiming;
use Packaged\Http\Interfaces\ResponseStatus;
use Packaged\Map\ArrayDataMap;

class Response extends HttpMessage
{
  protected $_statusCode;
  protected $_content;

  protected $_callTime;
  protected $_headersSent = false;
  protected $_sendDebugHeaders;

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

  /**
   * @return $this
   */
  public function disableDebugHeaders()
  {
    $this->_sendDebugHeaders = false;
    return $this;
  }

  /**
   * @return $this
   */
  public function enableDebugHeaders()
  {
    $this->_sendDebugHeaders = true;
    return $this;
  }

  /**
   * Set the microtime(true) value when the call started
   *
   * @param $time
   *
   * @return $this
   */
  public function setCallStartTime($time)
  {
    $this->_callTime = $time;
    return $this;
  }

  public function sendHeaders()
  {
    if(!$this->_headersSent && !headers_sent())
    {
      $this->_headersSent = true;
      $this->setDebugHeaders();

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
    return $this;
  }

  /**
   * Define Debug Headers
   *
   * Automatically called by ->send()
   */
  public function setDebugHeaders()
  {
    if($this->_sendDebugHeaders === true)
    {
      $timing = new ServerTiming();

      //Add the exec time as a header if PHP_START has been defined by the project
      if(defined('PHP_START'))
      {
        $timing->add('execution', (microtime(true) - PHP_START) * 1000, "Execution Time");
        $this->headers()->set(
          "x-execution-time",
          number_format((microtime(true) - PHP_START) * 1000, 3) . ' ms'
        );
      }

      if($this->_callTime > 0)
      {
        $this->headers()->set(
          'x-call-time',
          number_format((microtime(true) - $this->_callTime) * 1000, 3) . ' ms'
        );
        $timing->add('calltime', (microtime(true) - $this->_callTime) * 1000, "Call Time");
      }

      if($timing->hasTimings())
      {
        $this->addHeader($timing);
      }
    }
  }

  /**
   * Set a header, defaulting to replace the existing
   *
   * @param Header $header
   * @param bool   $replace
   *
   * @return $this
   */
  public function setHeader(Header $header, bool $replace = true)
  {
    if($replace)
    {
      $this->headers()->set($header->getKey(), $header->getValue());
    }
    else
    {
      $this->headers()->append($header->getKey(), $header->getValue());
    }
    return $this;
  }

  /**
   * Add a header, without replacing existing
   *
   * @param Header $header
   *
   * @return $this
   */
  public function addHeader(Header $header)
  {
    return $this->setHeader($header, false);
  }
}
