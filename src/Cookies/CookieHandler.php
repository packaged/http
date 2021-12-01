<?php

namespace Packaged\Http\Cookies;

interface CookieHandler
{
  /**
   * Check to see if the handler can handle a cookie
   *
   * @param string            $name
   * @param string|array|null $value
   *
   * @return bool
   */
  public function canHandle(string $name, $value = null): bool;

  /**
   * Decode a cookie name from transport
   *
   * @param string $name
   *
   * @return string
   */
  public function decodeName(string $name): string;

  /**
   * Encode a cookie name for transport
   *
   * @param string $name
   *
   * @return string
   */
  public function encodeName(string $name): string;

  /**
   * Decode a cookie value from transport
   *
   * @param string $value
   *
   * @return string
   */
  public function decodeValue(string $value): string;

  /**
   * Encode a cookie value for transport
   *
   * @param string $value
   *
   * @return string
   */
  public function encodeValue(string $value): string;
}
