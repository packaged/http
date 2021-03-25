<?php
namespace Packaged\Http\Files;

use Packaged\Map\TypedDataMap;

/**
 * @method RequestFile[] all
 * @method RequestFile|null get($key)
 */
class RequestFiles extends TypedDataMap
{
  public function __construct(array $data = []) { parent::__construct($data, [static::class, 'fromMixed']); }

  public static function fromMixed($value): ?RequestFile
  {
    if($value instanceof RequestFile)
    {
      return $value;
    }
    else if(is_array($value))
    {
      return new RequestFile($value);
    }
    return null;
  }
}
