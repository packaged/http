<?php
namespace Packaged\Http\Headers;

use function array_merge;
use function implode;
use function sprintf;

class ContentSecurityPolicy implements Header
{
  /* FETCH DIRECTIVES */
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

  /* DOCUMENT DIRECTIVES */
  const BASE_URI = 'base-uri';
  const PLUGIN_TYPES = 'plugin-types';
  const SANDBOX = 'sandbox';

  /* NAVIGATION DIRECTIVES */
  const FORM_ACTION = 'form-action';
  const FRAME_ANCESTORS = 'frame-ancestors';
  const NAVIGATE_TO = 'navigate-to';

  /* REPORTING DIRECTIVES */
  const REPORT_TO = 'report-to';
  const REPORT_URI = 'report-uri';

  /* OTHER DIRECTIVES */
  const BLOCK_ALL_MIXED_CONTENT = 'block-all-mixed-content';
  const REFERRER = 'referrer';
  const UPGRADE_INSECURE_REQUESTS = 'upgrade-insecure-requests';

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
