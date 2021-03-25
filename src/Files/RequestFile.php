<?php
namespace Packaged\Http\Files;

class RequestFile
{
  protected $_name;
  protected $_type;
  protected $_location;
  protected $_error;
  protected $_size;

  public function __construct(array $requestData)
  {
    $this->_name = $requestData['name'] ?? null;
    $this->_type = $requestData['type'] ?? null;
    $this->_location = $requestData['tmp_name'] ?? null;
    $this->_error = $requestData['error'] ?? null;
    $this->_size = $requestData['size'] ?? null;
  }

  /**
   * @return mixed|null
   */
  public function getName()
  {
    return $this->_name;
  }

  /**
   * @return mixed|null
   */
  public function getType()
  {
    return $this->_type;
  }

  /**
   * @return mixed|null
   */
  public function getLocation()
  {
    return $this->_location;
  }

  /**
   * @return mixed|null
   */
  public function getError()
  {
    return $this->_error;
  }

  /**
   * @return mixed|null
   */
  public function getSize()
  {
    return $this->_size;
  }

}
