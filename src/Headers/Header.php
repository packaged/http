<?php
namespace Packaged\Http\Headers;

interface Header
{
  public function getKey(): string;

  /**
   * @return string[]|string
   */
  public function getValue();
}
