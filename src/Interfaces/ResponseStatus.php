<?php
namespace Packaged\Http\Interfaces;

interface ResponseStatus
{
  const CONTINUE_REQUEST = 100;
  const SWITCHING_PROTOCOLS = 101;
  const PROCESSING = 102;            // RFC2518
  const OK = 200;
  const CREATED = 201;
  const ACCEPTED = 202;
  const NON_AUTHORITATIVE_INFORMATION = 203;
  const NO_CONTENT = 204;
  const RESET_CONTENT = 205;
  const PARTIAL_CONTENT = 206;
  const MULTI_STATUS = 207;          // RFC4918
  const ALREADY_REPORTED = 208;      // RFC5842
  const IM_USED = 226;               // RFC3229
  const MULTIPLE_CHOICES = 300;
  const MOVED_PERMANENTLY = 301;
  const FOUND = 302;
  const SEE_OTHER = 303;
  const NOT_MODIFIED = 304;
  const USE_PROXY = 305;
  const RESERVED = 306;
  const TEMPORARY_REDIRECT = 307;
  const PERMANENTLY_REDIRECT = 308;  // RFC7238
  const BAD_REQUEST = 400;
  const UNAUTHORIZED = 401;
  const PAYMENT_REQUIRED = 402;
  const FORBIDDEN = 403;
  const NOT_FOUND = 404;
  const METHOD_NOT_ALLOWED = 405;
  const NOT_ACCEPTABLE = 406;
  const PROXY_AUTHENTICATION_REQUIRED = 407;
  const REQUEST_TIMEOUT = 408;
  const CONFLICT = 409;
  const GONE = 410;
  const LENGTH_REQUIRED = 411;
  const PRECONDITION_FAILED = 412;
  const REQUEST_ENTITY_TOO_LARGE = 413;
  const REQUEST_URI_TOO_LONG = 414;
  const UNSUPPORTED_MEDIA_TYPE = 415;
  const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
  const EXPECTATION_FAILED = 417;
  const I_AM_A_TEAPOT = 418;                                               // RFC2324
  const MISDIRECTED_REQUEST = 421;                                         // RFC7540
  const UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
  const LOCKED = 423;                                                      // RFC4918
  const FAILED_DEPENDENCY = 424;                                           // RFC4918
  const RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
  const UPGRADE_REQUIRED = 426;                                            // RFC2817
  const PRECONDITION_REQUIRED = 428;                                       // RFC6585
  const TOO_MANY_REQUESTS = 429;                                           // RFC6585
  const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
  const UNAVAILABLE_FOR_LEGAL_REASONS = 451;
  const INTERNAL_SERVER_ERROR = 500;
  const NOT_IMPLEMENTED = 501;
  const BAD_GATEWAY = 502;
  const SERVICE_UNAVAILABLE = 503;
  const GATEWAY_TIMEOUT = 504;
  const VERSION_NOT_SUPPORTED = 505;
  const VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
  const INSUFFICIENT_STORAGE = 507;                                        // RFC4918
  const LOOP_DETECTED = 508;                                               // RFC5842
  const NOT_EXTENDED = 510;                                                // RFC2774
  const NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585

  const PHRASES = [
    // INFORMATIONAL CODES
    self::CONTINUE_REQUEST                                          => 'Continue',
    self::SWITCHING_PROTOCOLS                                       => 'Switching Protocols',
    self::PROCESSING                                                => 'Processing',
    // SUCCESS CODES
    self::OK                                                        => 'OK',
    self::CREATED                                                   => 'Created',
    self::ACCEPTED                                                  => 'Accepted',
    self::NON_AUTHORITATIVE_INFORMATION                             => 'Non-Authoritative Information',
    self::NO_CONTENT                                                => 'No Content',
    self::RESET_CONTENT                                             => 'Reset Content',
    self::PARTIAL_CONTENT                                           => 'Partial Content',
    self::MULTI_STATUS                                              => 'Multi-status',
    self::ALREADY_REPORTED                                          => 'Already Reported',
    self::IM_USED                                                   => 'Im Used',
    // REDIRECTION CODES
    self::MULTIPLE_CHOICES                                          => 'Multiple Choices',
    self::MOVED_PERMANENTLY                                         => 'Moved Permanently',
    self::FOUND                                                     => 'Found',
    self::SEE_OTHER                                                 => 'See Other',
    self::NOT_MODIFIED                                              => 'Not Modified',
    self::USE_PROXY                                                 => 'Use Proxy',
    self::RESERVED                                                  => 'Switch Proxy',
    // Deprecated
    self::TEMPORARY_REDIRECT                                        => 'Temporary Redirect',
    self::PERMANENTLY_REDIRECT                                      => 'Permanent Redirect',
    // CLIENT ERROR
    self::BAD_REQUEST                                               => 'Bad Request',
    self::UNAUTHORIZED                                              => 'Unauthorized',
    self::PAYMENT_REQUIRED                                          => 'Payment Required',
    self::FORBIDDEN                                                 => 'Forbidden',
    self::NOT_FOUND                                                 => 'Not Found',
    self::METHOD_NOT_ALLOWED                                        => 'Method Not Allowed',
    self::NOT_ACCEPTABLE                                            => 'Not Acceptable',
    self::PROXY_AUTHENTICATION_REQUIRED                             => 'Proxy Authentication Required',
    self::REQUEST_TIMEOUT                                           => 'Request Time-out',
    self::CONFLICT                                                  => 'Conflict',
    self::GONE                                                      => 'Gone',
    self::LENGTH_REQUIRED                                           => 'Length Required',
    self::PRECONDITION_FAILED                                       => 'Precondition Failed',
    self::REQUEST_ENTITY_TOO_LARGE                                  => 'Request Entity Too Large',
    self::REQUEST_URI_TOO_LONG                                      => 'Request-URI Too Large',
    self::UNSUPPORTED_MEDIA_TYPE                                    => 'Unsupported Media Type',
    self::REQUESTED_RANGE_NOT_SATISFIABLE                           => 'Requested range not satisfiable',
    self::EXPECTATION_FAILED                                        => 'Expectation Failed',
    self::I_AM_A_TEAPOT                                             => 'I\'m a teapot',
    self::MISDIRECTED_REQUEST                                       => 'Misdirected Entity',
    self::UNPROCESSABLE_ENTITY                                      => 'Unprocessable Entity',
    self::LOCKED                                                    => 'Locked',
    self::FAILED_DEPENDENCY                                         => 'Failed Dependency',
    self::RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL => 'Unordered Collection',
    self::UPGRADE_REQUIRED                                          => 'Upgrade Required',
    self::PRECONDITION_REQUIRED                                     => 'Precondition Required',
    self::TOO_MANY_REQUESTS                                         => 'Too Many Requests',
    self::REQUEST_HEADER_FIELDS_TOO_LARGE                           => 'Request Header Fields Too Large',
    self::UNAVAILABLE_FOR_LEGAL_REASONS                             => 'Unavailable for Legal Reasons',
    // SERVER ERROR
    self::INTERNAL_SERVER_ERROR                                     => 'Internal Server Error',
    self::NOT_IMPLEMENTED                                           => 'Not Implemented',
    self::BAD_GATEWAY                                               => 'Bad Gateway',
    self::SERVICE_UNAVAILABLE                                       => 'Service Unavailable',
    self::GATEWAY_TIMEOUT                                           => 'Gateway Time-out',
    self::VERSION_NOT_SUPPORTED                                     => 'HTTP Version not supported',
    self::VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL                      => 'Variant Also Negotiates',
    self::INSUFFICIENT_STORAGE                                      => 'Insufficient Storage',
    self::LOOP_DETECTED                                             => 'Loop Detected',
    self::NOT_EXTENDED                                              => 'Network Authentication Required',
  ];

}
