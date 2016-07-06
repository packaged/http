<?php
namespace Packaged\Http\Helpers;

use Packaged\Http\Interfaces\ResponseStatus;

class ResponseHelper
{
  private static $codes = [
    // INFORMATIONAL CODES
    ResponseStatus::HTTP_CONTINUE => 'Continue',
    ResponseStatus::HTTP_SWITCHING_PROTOCOLS => 'Switching Protocols',
    ResponseStatus::HTTP_PROCESSING => 'Processing',
    // SUCCESS CODES
    ResponseStatus::HTTP_OK => 'OK',
    ResponseStatus::HTTP_CREATED => 'Created',
    ResponseStatus::HTTP_ACCEPTED => 'Accepted',
    ResponseStatus::HTTP_NON_AUTHORITATIVE_INFORMATION => 'Non-Authoritative Information',
    ResponseStatus::HTTP_NO_CONTENT => 'No Content',
    ResponseStatus::HTTP_RESET_CONTENT => 'Reset Content',
    ResponseStatus::HTTP_PARTIAL_CONTENT => 'Partial Content',
    ResponseStatus::HTTP_MULTI_STATUS => 'Multi-status',
    ResponseStatus::HTTP_ALREADY_REPORTED => 'Already Reported',
    ResponseStatus::HTTP_IM_USED => 'Im Used',
    // REDIRECTION CODES
    ResponseStatus::HTTP_MULTIPLE_CHOICES => 'Multiple Choices',
    ResponseStatus::HTTP_MOVED_PERMANENTLY => 'Moved Permanently',
    ResponseStatus::HTTP_FOUND => 'Found',
    ResponseStatus::HTTP_SEE_OTHER => 'See Other',
    ResponseStatus::HTTP_NOT_MODIFIED => 'Not Modified',
    ResponseStatus::HTTP_USE_PROXY => 'Use Proxy',
    ResponseStatus::HTTP_RESERVED => 'Switch Proxy', // Deprecated
    ResponseStatus::HTTP_TEMPORARY_REDIRECT => 'Temporary Redirect',
    ResponseStatus::HTTP_PERMANENTLY_REDIRECT => 'Permanent Redirect',
    // CLIENT ERROR
    ResponseStatus::HTTP_BAD_REQUEST => 'Bad Request',
    ResponseStatus::HTTP_UNAUTHORIZED => 'Unauthorized',
    ResponseStatus::HTTP_PAYMENT_REQUIRED => 'Payment Required',
    ResponseStatus::HTTP_FORBIDDEN => 'Forbidden',
    ResponseStatus::HTTP_NOT_FOUND => 'Not Found',
    ResponseStatus::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
    ResponseStatus::HTTP_NOT_ACCEPTABLE => 'Not Acceptable',
    ResponseStatus::HTTP_PROXY_AUTHENTICATION_REQUIRED => 'Proxy Authentication Required',
    ResponseStatus::HTTP_REQUEST_TIMEOUT => 'Request Time-out',
    ResponseStatus::HTTP_CONFLICT => 'Conflict',
    ResponseStatus::HTTP_GONE => 'Gone',
    ResponseStatus::HTTP_LENGTH_REQUIRED => 'Length Required',
    ResponseStatus::HTTP_PRECONDITION_FAILED => 'Precondition Failed',
    ResponseStatus::HTTP_REQUEST_ENTITY_TOO_LARGE => 'Request Entity Too Large',
    ResponseStatus::HTTP_REQUEST_URI_TOO_LONG => 'Request-URI Too Large',
    ResponseStatus::HTTP_UNSUPPORTED_MEDIA_TYPE => 'Unsupported Media Type',
    ResponseStatus::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE => 'Requested range not satisfiable',
    ResponseStatus::HTTP_EXPECTATION_FAILED => 'Expectation Failed',
    ResponseStatus::HTTP_I_AM_A_TEAPOT => 'I\'m a teapot',
    ResponseStatus::HTTP_MISDIRECTED_REQUEST => 'Misdirected Entity',
    ResponseStatus::HTTP_UNPROCESSABLE_ENTITY => 'Unprocessable Entity',
    ResponseStatus::HTTP_LOCKED => 'Locked',
    ResponseStatus::HTTP_FAILED_DEPENDENCY => 'Failed Dependency',
    ResponseStatus::HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL => 'Unordered Collection',
    ResponseStatus::HTTP_UPGRADE_REQUIRED => 'Upgrade Required',
    ResponseStatus::HTTP_PRECONDITION_REQUIRED => 'Precondition Required',
    ResponseStatus::HTTP_TOO_MANY_REQUESTS => 'Too Many Requests',
    ResponseStatus::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE => 'Request Header Fields Too Large',
    ResponseStatus::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS => 'Unavailable for Legal Reasons',
    // SERVER ERROR
    ResponseStatus::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ResponseStatus::HTTP_NOT_IMPLEMENTED => 'Not Implemented',
    ResponseStatus::HTTP_BAD_GATEWAY => 'Bad Gateway',
    ResponseStatus::HTTP_SERVICE_UNAVAILABLE => 'Service Unavailable',
    ResponseStatus::HTTP_GATEWAY_TIMEOUT => 'Gateway Time-out',
    ResponseStatus::HTTP_VERSION_NOT_SUPPORTED => 'HTTP Version not supported',
    ResponseStatus::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL => 'Variant Also Negotiates',
    ResponseStatus::HTTP_INSUFFICIENT_STORAGE => 'Insufficient Storage',
    ResponseStatus::HTTP_LOOP_DETECTED => 'Loop Detected',
    ResponseStatus::HTTP_NOT_EXTENDED => 'Network Authentication Required',
  ];

  public static function supportedStatusCodes()
  {
    return static::$codes;
  }

  public static function getReasonPhrase($statusCode)
  {
    return isset(static::$codes[$statusCode]) ?
      static::$codes[$statusCode] : null;
  }

  public static function validateStatusCode($statusCode)
  {
    $statusCode = (int)$statusCode;

    if(!array_key_exists($statusCode, static::supportedStatusCodes()))
    {
      throw new \InvalidArgumentException(
        'Invalid status code: ' . $statusCode
      );
    }

    return $statusCode;
  }
}
