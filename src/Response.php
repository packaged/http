<?php
namespace Packaged\Http;

use Packaged\Http\Headers\Header;
use Packaged\Http\Headers\ServerTiming;

class Response extends \Symfony\Component\HttpFoundation\Response
{
  protected $_callTime;
  protected $_headersSent = false;
  protected $_sendDebugHeaders;

  /**
   * @return string
   */
  public function getStatusText()
  {
    return $this->statusText;
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

  protected $_originalSource;

  /**
   * Add Debug Headers before sending
   *
   * @inheritdoc
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function sendHeaders()
  {
    if(!$this->_headersSent)
    {
      $this->_headersSent = true;
      $this->setDebugHeaders();
      return parent::sendHeaders();
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
        $this->headers->set(
          "x-execution-time",
          number_format((microtime(true) - PHP_START) * 1000, 3) . ' ms'
        );
      }

      if($this->_callTime > 0)
      {
        $this->headers->set(
          'x-call-time',
          number_format((microtime(true) - $this->_callTime) * 1000, 3) . ' ms'
        );
        $timing->add('calltime', (microtime(true) - $this->_callTime) * 1000, "Call Time");
      }

      if($timing->hasTimings())
      {
        $this->setHeader($timing);
      }
    }
  }

  public function setHeader(Header $header, bool $replace = true)
  {
    $this->headers->set($header->getKey(), $header->getValue(), $replace);
    return $this;
  }
}
