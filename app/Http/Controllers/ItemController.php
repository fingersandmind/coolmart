<?php

namespace App\Http\Controllers;

use App\Item;
use App\Brand;
use App\Type;
use App\Category;
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
        $items = Item::get();

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
        // dd($request->all());
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
        $request->validated();

        $item->persists($request);
        
        return redirect()->route('items.show',$item->slug)->withSuccess('Successfully updated!');
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
        $item->delete();

        return redirect()->route('items.index')->withSuccess('Successfully deleted!');
    }
}
