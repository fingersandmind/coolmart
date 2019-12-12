<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Brand;
use App\Type;
use App\Category;
use App\Item;
use App\UnitModel;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::get();

        return view('pages.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $request->validated();
        
        $brand = new Brand();

        $brand->persists($request);

        if($request->action == 'save')
        {
            return redirect()->route('brands.index')->withSuccess('Succesfully added!');
        }elseif($request->action == 'continue')
        {
            return redirect()->route('brands.create')->withSuccess('Succesfully added!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Brand $brand)
    {
        if($request->get('action') == 'clear')
        {
            return redirect()->route('brands.show', $brand->slug);
        }
        $types = Type::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $items = Item::filter($request->all())->where('brand_id', $brand->id)->paginate(6);
        return view('pages.brands.show', compact('brand', 'types', 'categories', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('pages.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        if($request->action == 'feature')
        {
            $brand->featureBrand();
            return redirect()->route('brands.show', $brand->slug)->withToastSuccess($brand->is_featured ? 'Featured!' : 'Unfeatured!');
        }

        $request->validated();
        $brand->persists($request);

        return redirect()->route('brands.index')->withSuccess('Succesfully added!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->deleteImage();
        
        $brand->delete();
        return redirect()->route('brands.index')->withSuccess('Succesfully deleted!');
    }
}
