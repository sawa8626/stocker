<?php

namespace App\Services;

use App\Models\ItemDetail;
use Carbon\Carbon;

class EditItemDetailService {
  public function startItemDetail($item_id)
  {
    $item_detail = ItemDetail::where('item_id', $item_id)->whereNull('start_day')->first();
    $item_detail->start_day = Carbon::today();
    $item_detail->using = true;
    $item_detail->save();
  }

  public function endItemDetail($item_id)
  {
    $item_detail = ItemDetail::where('item_id', $item_id)->where('using', true)->first();
    $item_detail->end_day = Carbon::today();
    $start_day = new Carbon($item_detail->start_day); // Carbonインスタンスに変換
    $item_detail->use_term = $start_day->diffInDays($item_detail->end_day);
    $item_detail->using = false;
    $item_detail->save();
  }
}