<?php
namespace Packaged\Http\Headers;

class XRobotsTag implements Header
{
  const OPT_NO_INDEX = 'noindex';
  const OPT_NO_FOLLOW = 'nofollow';
  const OPT_NO_ARCHIVE = 'noarchive';
  const OPT_NONE = 'none';//noindex,nofollow
  const OPT_NO_SNIPPET = 'nosnippet';
  const OPT_NO_TRANSLATE = 'notranslate';
  const OPT_NO_IMAGEINDEX = 'noimageindex';

  protected $_options = [];

  public function getKey(): string
  {
    return 'x-robots-tag';
  }

  public function noIndex()
  {
    $this->_options[self::OPT_NO_INDEX] = self::OPT_NO_INDEX;
    return $this;
  }

  public function noFollow()
  {
    $this->_options[self::OPT_NO_FOLLOW] = self::OPT_NO_FOLLOW;
    return $this;
  }

  public function noArchive()
  {
    $this->_options[self::OPT_NO_ARCHIVE] = self::OPT_NO_ARCHIVE;
    return $this;
  }

  public function none()
  {
    $this->_options[self::OPT_NONE] = self::OPT_NONE;
    return $this;
  }

  public function noSnippet()
  {
    $this->_options[self::OPT_NO_SNIPPET] = self::OPT_NO_SNIPPET;
    return $this;
  }

  public function noTranslate()
  {
    $this->_options[self::OPT_NO_TRANSLATE] = self::OPT_NO_TRANSLATE;
    return $this;
  }

  public function noImageindex()
  {
    $this->_options[self::OPT_NO_IMAGEINDEX] = self::OPT_NO_IMAGEINDEX;
    return $this;
  }

  public function getValue()
  {
    return implode($this->_options);
  }
}
