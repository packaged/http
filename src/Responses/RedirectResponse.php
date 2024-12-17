<?php
namespace Packaged\Http\Responses;

class RedirectResponse extends \Symfony\Component\HttpFoundation\RedirectResponse
{
  public static function create($url, $status = 302, $headers = []): static
  {
    return new static($url, $status, $headers);
  }
}
