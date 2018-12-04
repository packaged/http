<?php
namespace Packaged\Http;

class Response extends \Symfony\Component\HttpFoundation\Response
{
  protected $_callTime;
  protected $_sendDebugHeaders = true;

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
   * Add Debug Headers before sending the response
   *
   * @inheritdoc
   *
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function send()
  {
    $this->setDebugHeaders();
    return parent::send();
  }

  /**
   * Define Debug Headers
   *
   * Automatically called by ->send()
   */
  public function setDebugHeaders()
  {
    if($this->_sendDebugHeaders)
    {
      //Add the exec time as a header if PHP_START has been defined by the project
      if(defined('PHP_START'))
      {
        $this->headers->set(
          "X-Execution-Time",
          number_format((microtime(true) - PHP_START) * 1000, 3) . ' ms'
        );
      }

      if($this->_callTime > 0)
      {
        $this->headers->set(
          'X-Call-Time',
          number_format((microtime(true) - $this->_callTime) * 1000, 3) . ' ms'
        );
      }
    }
  }
}
