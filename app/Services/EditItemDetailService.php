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
}