<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Brands\BrandsResource;
use App\Http\Resources\Brands\BrandResource;
use App\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::with('items')->get();

        return new BrandsResource($brands);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        BrandResource::withoutWrapping();

        return new BrandResource($brand);
    }

    public function featured()
    {
        $brand = Brand::featured()->with('items')->latest()->first();

        return new BrandResource($brand);
    }
}
