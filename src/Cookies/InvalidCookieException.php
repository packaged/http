<?php
namespace Packaged\Http\Cookies;

/**
 * Thrown by a CookieHandler that rejects a request cookie's value. The CookieJar leaves that cookie out.
 */
class InvalidCookieException extends \RuntimeException
{
}
