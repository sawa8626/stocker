<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Http\Requests\StoreItem;
use Carbon\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('details')->where('user_id', Auth::id())->get();

        // nav-bar用ジャンル配列の作成
        $genre = [];
        foreach($items as $item)
        {
            $genre[] = $item->genre;
        };
        $genre_for_nav = array_unique($genre);

        // indexページに表示する各item情報作成
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
                $item->use_term_avg = array_sum($use_terms) / $number_of_use_term;
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
            };
        };

        return view('items.index', compact('items', 'genre_for_nav'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem $request)
    {
        $item = new Item;
        $item_detail = new ItemDetail;

        $item->name = $request->input('name');
        $item->genre = $request->input('genre');
        $item->price = $request->input('price');
        $item->user_id = Auth::id();
        $item->save();

        $saved_item = DB::table('items')->where('name', $request->input('name'))->first();

        $item_detail->item_id = $saved_item->id;
        $item_detail->save();

        return redirect('items/index');
    }

    public function start($item_id)
    {
        $item_detail = ItemDetail::where('item_id', $item_id)->whereNull('start_day')->first();
        $item_detail->start_day = Carbon::today();
        $item_detail->using = true;
        $item_detail->save();

        return redirect('items/index');
    }

    public function end($item_id)
    {
        $item_detail = ItemDetail::where('item_id', $item_id)->where('using', true)->first();
        $item_detail->end_day = Carbon::today();
        $start_day = new Carbon($item_detail->start_day); // Carbonインスタンスに変換
        $item_detail->use_term = $start_day->diffInDays($item_detail->end_day);
        $item_detail->using = false;
        $item_detail->save();

        return redirect('items/index');
    }

    public function add($item_id)
    {
        $item_detail = new ItemDetail;
        $item_detail->item_id = $item_id;
        $item_detail->save();

        return redirect('items/index');
    }

    public function exchange($item_id)
    {
        $item_detail_end = ItemDetail::where('item_id', $item_id)->where('using', true)->first();
        $item_detail_end->end_day = Carbon::today();
        $start_day = new Carbon($item_detail_end->start_day); // Carbonインスタンスに変換
        $item_detail_end->use_term = $start_day->diffInDays($item_detail_end->end_day);
        $item_detail_end->using = false;
        $item_detail_end->save();

        $item_detail_start = ItemDetail::where('item_id', $item_id)->whereNull('start_day')->first();
        $item_detail_start->start_day = Carbon::today();
        $item_detail_start->using = true;
        $item_detail_start->save();

        return redirect('items/index');
    }

    public function sort_index($item_genre)
    {
        $items = Item::with('details')->where('user_id', Auth::id())
        ->where('genre', $item_genre)->get();

        // indexページに表示する各item情報作成
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
                $item->use_term_avg = array_sum($use_terms) / $number_of_use_term;
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
            };
        };

        $items_for_genre = Item::with('details')->where('user_id', Auth::id())->get();

        // nav-bar用ジャンル配列の作成
        $genre = [];
        foreach($items_for_genre as $item)
        {
            $genre[] = $item->genre;
        };
        $genre_for_nav = array_unique($genre);

        return view('items.index', compact('items', 'genre_for_nav'));
    }

}
