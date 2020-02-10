<?php
namespace Packaged\Http\Headers;

class UpgradeInsecureRequests implements Header
{
  public function getKey(): string
  {
    return 'Upgrade-Insecure-Requests';
  }

  public function getValue()
  {
    return 1;
  }
}
