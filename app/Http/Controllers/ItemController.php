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

        foreach($items as $item)
        {
            $using_item = ItemDetail::where('item_id', $item->id)
            ->whereNull('end_day')->whereNotNull('start_day')->get();
            $item->using_number = $using_item->count();

            $stock_item = ItemDetail::where('item_id', $item->id)
            ->whereNull('start_day')->get();
            $item->stock_number = $stock_item->count();
        };

        return view('items.index', compact('items'));
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
        $item_detail = ItemDetail::where('item_id', $item_id)->where('start_day', null)->first();
        $item_detail->start_day = Carbon::today();
        $item_detail->using = true;
        $item_detail->save();

        return redirect('items/index');
    }









    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
