<?php

namespace App\Http\Controllers;

use App\Item;
use App\Brand;
use App\Type;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('details')->get();

        return view('pages.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $types = Type::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('pages.items.create', compact('brands', 'types', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request)
    {
        $request->validated();

        $item = new Item();
        $item->persists($request);

        return redirect()->route('items.index')->withSuccess('Successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('pages.items.show',compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $brands = Brand::pluck('name', 'id');
        $types = Type::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('pages.items.edit', compact('item','brands', 'types', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemRequest $request, Item $item)
    {
        if($request->action == 'feature')
        {
            $item->featureItem();
            return redirect()->route('items.show', $item->slug)->withToastSuccess($item->is_featured ? 'Featured!' : 'Unfeatured!');
        }
        $request->validated();

        $item->persists($request);
        
        return redirect()->route('items.show', $request->slug)->withSuccess('Successfully updated!');
    }
    /**
     * Applying Discount for Items
     * @param Request $request
     * @param App\Item $item
     * 
     * @return \Illuminate\Http\Response
     */

    public function applyDiscount(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|min:2|max:20',
            'type' => 'required',
            'percent_off' => 'sometimes|required|numeric|between:1,100',
            'amount' => 'sometimes|required|numeric',
        ]);
        $amount = $request->type == 'cash_off' ? $request->amount : 0;
        $percentage = $request->type == 'percentage' ? $request->percent_off : 0;

        $item->discount()->updateOrCreate(
            ['discountable_id' => $item->id],
            [
                'name' => $request->name,
                'type' => $request->type,
                'percent_off' => $percentage,
                'amount' => $amount
            ]
        );

        return redirect()->route('items.show', $item->slug)->withToastSuccess('Discount applied!');
    }

    public function removeDiscount(Item $item)
    {
        $item->discount->delete();
        return redirect()->route('items.show', $item->slug)->withToastSuccess('Discount deleted!');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->deleteImage();
        $item->details()->delete();
        $item->delete();

        return redirect()->route('items.index')->withSuccess('Successfully deleted!');
    }
}
