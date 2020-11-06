<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Auth;

class CreateItemService {
  public function storeItemObject($item, $request)
  {
    $item->name = $request->input('name');
    $item->genre = $request->input('genre');
    $item->price = $request->input('price');
    $item->user_id = Auth::id();
    $item->save();
  }

  public function storeItemDetailObject($item_detail, $request)
  {
    $saved_item = DB::table('items')->where('name', $request->input('name'))->first();
    $item_detail->item_id = $saved_item->id;
    $item_detail->save();
  }
}
