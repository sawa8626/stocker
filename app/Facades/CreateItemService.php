<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CreateItemService extends Facade
{
  protected static function getFacadeAccessor() {
    return 'CreateItemService';
  }
}
