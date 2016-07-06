<?php
namespace Packaged\Http\Helpers;

use Packaged\Http\Interfaces\ResponseStatus;

class ResponseHelper
{
  private static $codes = [
    // INFORMATIONAL CODES
    ResponseStatus::CONTINUE_REQUEST                                          => 'Continue',
    ResponseStatus::SWITCHING_PROTOCOLS                                       => 'Switching Protocols',
    ResponseStatus::PROCESSING                                                => 'Processing',
    // SUCCESS CODES
    ResponseStatus::OK                                                        => 'OK',
    ResponseStatus::CREATED                                                   => 'Created',
    ResponseStatus::ACCEPTED                                                  => 'Accepted',
    ResponseStatus::NON_AUTHORITATIVE_INFORMATION                             => 'Non-Authoritative Information',
    ResponseStatus::NO_CONTENT                                                => 'No Content',
    ResponseStatus::RESET_CONTENT                                             => 'Reset Content',
    ResponseStatus::PARTIAL_CONTENT                                           => 'Partial Content',
    ResponseStatus::MULTI_STATUS                                              => 'Multi-status',
    ResponseStatus::ALREADY_REPORTED                                          => 'Already Reported',
    ResponseStatus::IM_USED                                                   => 'Im Used',
    // REDIRECTION CODES
    ResponseStatus::MULTIPLE_CHOICES                                          => 'Multiple Choices',
    ResponseStatus::MOVED_PERMANENTLY                                         => 'Moved Permanently',
    ResponseStatus::FOUND                                                     => 'Found',
    ResponseStatus::SEE_OTHER                                                 => 'See Other',
    ResponseStatus::NOT_MODIFIED                                              => 'Not Modified',
    ResponseStatus::USE_PROXY                                                 => 'Use Proxy',
    ResponseStatus::RESERVED                                                  => 'Switch Proxy',
    // Deprecated
    ResponseStatus::TEMPORARY_REDIRECT                                        => 'Temporary Redirect',
    ResponseStatus::PERMANENTLY_REDIRECT                                      => 'Permanent Redirect',
    // CLIENT ERROR
    ResponseStatus::BAD_REQUEST                                               => 'Bad Request',
    ResponseStatus::UNAUTHORIZED                                              => 'Unauthorized',
    ResponseStatus::PAYMENT_REQUIRED                                          => 'Payment Required',
    ResponseStatus::FORBIDDEN                                                 => 'Forbidden',
    ResponseStatus::NOT_FOUND                                                 => 'Not Found',
    ResponseStatus::METHOD_NOT_ALLOWED                                        => 'Method Not Allowed',
    ResponseStatus::NOT_ACCEPTABLE                                            => 'Not Acceptable',
    ResponseStatus::PROXY_AUTHENTICATION_REQUIRED                             => 'Proxy Authentication Required',
    ResponseStatus::REQUEST_TIMEOUT                                           => 'Request Time-out',
    ResponseStatus::CONFLICT                                                  => 'Conflict',
    ResponseStatus::GONE                                                      => 'Gone',
    ResponseStatus::LENGTH_REQUIRED                                           => 'Length Required',
    ResponseStatus::PRECONDITION_FAILED                                       => 'Precondition Failed',
    ResponseStatus::REQUEST_ENTITY_TOO_LARGE                                  => 'Request Entity Too Large',
    ResponseStatus::REQUEST_URI_TOO_LONG                                      => 'Request-URI Too Large',
    ResponseStatus::UNSUPPORTED_MEDIA_TYPE                                    => 'Unsupported Media Type',
    ResponseStatus::REQUESTED_RANGE_NOT_SATISFIABLE                           => 'Requested range not satisfiable',
    ResponseStatus::EXPECTATION_FAILED                                        => 'Expectation Failed',
    ResponseStatus::I_AM_A_TEAPOT                                             => 'I\'m a teapot',
    ResponseStatus::MISDIRECTED_REQUEST                                       => 'Misdirected Entity',
    ResponseStatus::UNPROCESSABLE_ENTITY                                      => 'Unprocessable Entity',
    ResponseStatus::LOCKED                                                    => 'Locked',
    ResponseStatus::FAILED_DEPENDENCY                                         => 'Failed Dependency',
    ResponseStatus::RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL => 'Unordered Collection',
    ResponseStatus::UPGRADE_REQUIRED                                          => 'Upgrade Required',
    ResponseStatus::PRECONDITION_REQUIRED                                     => 'Precondition Required',
    ResponseStatus::TOO_MANY_REQUESTS                                         => 'Too Many Requests',
    ResponseStatus::REQUEST_HEADER_FIELDS_TOO_LARGE                           => 'Request Header Fields Too Large',
    ResponseStatus::UNAVAILABLE_FOR_LEGAL_REASONS                             => 'Unavailable for Legal Reasons',
    // SERVER ERROR
    ResponseStatus::INTERNAL_SERVER_ERROR                                     => 'Internal Server Error',
    ResponseStatus::NOT_IMPLEMENTED                                           => 'Not Implemented',
    ResponseStatus::BAD_GATEWAY                                               => 'Bad Gateway',
    ResponseStatus::SERVICE_UNAVAILABLE                                       => 'Service Unavailable',
    ResponseStatus::GATEWAY_TIMEOUT                                           => 'Gateway Time-out',
    ResponseStatus::VERSION_NOT_SUPPORTED                                     => 'HTTP Version not supported',
    ResponseStatus::VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL                      => 'Variant Also Negotiates',
    ResponseStatus::INSUFFICIENT_STORAGE                                      => 'Insufficient Storage',
    ResponseStatus::LOOP_DETECTED                                             => 'Loop Detected',
    ResponseStatus::NOT_EXTENDED                                              => 'Network Authentication Required',
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
