<?php
namespace Packaged\Http\Interfaces;

interface RequestMethod
{
  const CONNECT = 'CONNECT';
  const DELETE = 'DELETE';
  const GET = 'GET';
  const HEAD = 'HEAD';
  const OPTIONS = 'OPTIONS';
  const PATCH = 'PATCH';
  const POST = 'POST';
  const PUT = 'PUT';
  const TRACE = 'TRACE';

  const SUPPORTED_METHODS = [
    RequestMethod::CONNECT => RequestMethod::CONNECT,
    RequestMethod::DELETE  => RequestMethod::DELETE,
    RequestMethod::GET     => RequestMethod::GET,
    RequestMethod::HEAD    => RequestMethod::HEAD,
    RequestMethod::OPTIONS => RequestMethod::OPTIONS,
    RequestMethod::PATCH   => RequestMethod::PATCH,
    RequestMethod::POST    => RequestMethod::POST,
    RequestMethod::PUT     => RequestMethod::PUT,
    RequestMethod::TRACE   => RequestMethod::TRACE,
  ];
}
