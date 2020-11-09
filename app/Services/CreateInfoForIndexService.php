<?php

namespace App\Services;

use App\Models\ItemDetail;
use Carbon\Carbon;

class CreateInfoForIndexService {
  public function generateGenreArrayForNav($items)
  {
    $genre = [];
    foreach($items as $item)
    {
        $genre[] = $item->genre;
    };
    $genre_for_nav = array_unique($genre);
    return $genre_for_nav;
  }

  public function generateDetailInfoForDisplay($items)
  {
    foreach($items as $item)
    {
        // 使用中itemの個数算出
        $using_item = ItemDetail::where('item_id', $item->id)
        ->whereNull('end_day')->whereNotNull('start_day')->get();
        $item->using_number = $using_item->count();

        // 未使用itemの在庫算出
        $stock_item = ItemDetail::where('item_id', $item->id)
        ->whereNull('start_day')->get();
        $item->stock_number = $stock_item->count();

        // itemの平均使用日数の算出
        $items_by_use_term = ItemDetail::where('item_id', $item->id)
        ->whereNotNull('use_term')->get();

        if($items_by_use_term->isEmpty())
        {
            $item->use_term_avg = 0;
        }
        if(!$items_by_use_term->isEmpty())
        {
            $use_terms = [];

            foreach($items_by_use_term as $item_by_use_term)
            {
                $use_terms[] = $item_by_use_term->use_term;
            }

            $number_of_use_term = count($use_terms);
            $item->use_term_avg = round(array_sum($use_terms) / $number_of_use_term, 1);
        }
        
        // 推定残量の算出
        $using_item = ItemDetail::where('item_id', $item->id)
        ->whereNull('end_day')->whereNotNull('start_day')->first();
        if(isset($using_item))
        {
            $start_day = $using_item->start_day;
            $start_day_carbon = new Carbon($start_day);
            $elapsed_days = $start_day_carbon->diffInDays(Carbon::today());
            $difference = $item->use_term_avg - $elapsed_days;
            if($difference !== 0 && $item->use_term_avg !== 0)
            {
                $item->remaining_amount = round(($difference / $item->use_term_avg) * 100);
            }
            if($difference === 0)
            {
                $item->remaining_amount = null;
            }
        }
    }
  }
}
