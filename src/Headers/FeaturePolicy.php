<?php
namespace Packaged\Http\Headers;

class FeaturePolicy implements Header
{
  public function getKey(): string
  {
    return 'feature-policy';
  }

  public function getValue()
  {
    return "accelerometer 'none'"
      . ";camera 'none'"
      . ";geolocation 'none'"
      . ";gyroscope 'none'"
      . ";magnetometer 'none'"
      . ";microphone 'none'"
      . ";payment 'none'"
      . ";usb 'none'";
  }
}
