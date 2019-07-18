<?php
namespace Packaged\Http\Headers;

use function array_merge;
use function implode;
use function sprintf;

class ContentSecurityPolicy implements Header
{
  /* DIRECTIVES */
  const CHILD_SRC = 'child-src';
  const CONNECT_SRC = 'connect-src';
  const DEFAULT_SRC = 'default-src';
  const FONT_SRC = 'font-src';
  const FRAME_SRC = 'frame-src';
  const IMG_SRC = 'img-src';
  const MANIFEST_SRC = 'manifest-src';
  const MEDIA_SRC = 'media-src';
  const OBJECT_SRC = 'object-src';
  const PREFETCH_SRC = 'prefetch-src';
  const SCRIPT_SRC = 'script-src';
  const SCRIPT_SRC_ELEM = 'script-src-elem';
  const SCRIPT_SRC_ATTR = 'script-src-attr';
  const STYLE_SRC = 'style-src';
  const STYLE_SRC_ELEM = 'style-src-elem';
  const STYLE_SRC_ATTR = 'style-src-attr';
  const WORKER_SRC = 'worker-src';

  protected $_directives = ['default-src' => ["'self'"]];

  public function getKey(): string
  {
    return 'content-security-policy';
  }

  public function getValue()
  {
    $directives = [];
    foreach($this->_directives as $directive => $policy)
    {
      $directives[] = sprintf("%s %s", $directive, implode(" ", $policy));
    }

    return implode('; ', $directives);
  }

  public function setDirective($directive, ...$src)
  {
    $this->_directives[$directive] = $src;
    return $this;
  }

  public function appendDirective($directive, ...$src)
  {
    $this->_directives[$directive] = array_merge($this->_directives[$directive], $src);
    return $this;
  }

}
