<?php
namespace Packaged\Http\Headers;

use function array_filter;
use function implode;

class ContentSecurityPolicy implements Header
{
  protected $_defaultSrc = ["'self'"];
  protected $_styleSrc = [];
  protected $_frameSrc = [];
  protected $_mediaSrc = [];
  protected $_fontSrc = [];
  protected $_scriptSrc = [];

  public function getKey(): string
  {
    return 'content-security-policy';
  }

  public function getValue()
  {
    return implode(
      '; ',
      array_filter(
        [
          $this->_formatOptions('default-src', $this->_defaultSrc),
          $this->_formatOptions('style-src', $this->_styleSrc),
          $this->_formatOptions('frame-src', $this->_frameSrc),
          $this->_formatOptions('media-src', $this->_mediaSrc),
          $this->_formatOptions('font-src', $this->_fontSrc),
          $this->_formatOptions('script-src', $this->_scriptSrc),
        ]
      )
    );
  }

  protected function _formatOptions(string $type, array $options): string
  {
    if(empty($options))
    {
      return '';
    }
    return $type . " " . implode(' ', $options);
  }

  public function addDefaultSrc($src)
  {
    $this->_defaultSrc[] = $src;
    return $this;
  }

  public function addStyleSrc($src)
  {
    $this->_styleSrc[] = $src;
    return $this;
  }

  public function addFrameSrc($src)
  {
    $this->_frameSrc[] = $src;
    return $this;
  }

  public function addMediaSrc($src)
  {
    $this->_mediaSrc[] = $src;
    return $this;
  }

  public function addFontSrc($src)
  {
    $this->_fontSrc[] = $src;
    return $this;
  }

  public function addScriptSrc($src)
  {
    $this->_scriptSrc[] = $src;
    return $this;
  }

}
