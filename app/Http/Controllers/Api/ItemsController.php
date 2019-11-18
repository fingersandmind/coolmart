<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Items\ItemResource;
use App\Http\Resources\Items\ItemsResource;
use App\Item;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Item::filter($request->all())->with('brand','type', 'images')
        ->orderBy('created_at', 'DESC')
        ->paginate(15);

        return new ItemsResource($items);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        ItemResource::withoutWrapping();

        return new ItemResource($item);
    }

    /**
     * Display featured Items
     */

    public function isFeatured()
    {
        $items = Item::where('is_featured', true)->paginate(15);
        
        return new ItemsResource($items);
    }

    /**
     * Display discounted Items
     */

    public function discount()
    {
        $items = Item::has('discount')->paginate(15);

        return new ItemsResource($items);
    }
}
