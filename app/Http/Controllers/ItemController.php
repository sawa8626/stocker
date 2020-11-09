<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Item;
use App\Models\ItemDetail;
use App\Http\Requests\StoreItem;
use App\Facades\CreateItemService;
use App\Facades\EditItemDetailService;
use App\Facades\CreateInfoForIndexService;

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
        $genre_for_nav = CreateInfoForIndexService::generateGenreArrayForNav($items);

        // indexページに表示する各item情報作成
        CreateInfoForIndexService::generateDetailInfoForDisplay($items);

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

        CreateItemService::storeItemObject($item, $request);
        CreateItemService::storeItemDetailObject($item_detail, $request);

        return redirect('items/index');
    }

    public function start($item_id)
    {
        EditItemDetailService::startItemDetail($item_id);

        return redirect('items/index');
    }

    public function end($item_id)
    {
        EditItemDetailService::endItemDetail($item_id);

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
        EditItemDetailService::endItemDetail($item_id);
        EditItemDetailService::startItemDetail($item_id);

        return redirect('items/index');
    }

    public function sort_index($item_genre)
    {
        $items = Item::with('details')->where('user_id', Auth::id())
        ->where('genre', $item_genre)->get();

        // indexページに表示する各item情報作成
        CreateInfoForIndexService::generateDetailInfoForDisplay($items);

        $items_for_genre = Item::with('details')->where('user_id', Auth::id())->get();

        // nav-bar用ジャンル配列の作成
        $genre_for_nav = CreateInfoForIndexService::generateGenreArrayForNav($items_for_genre);

        return view('items.index', compact('items', 'genre_for_nav'));
    }

}
