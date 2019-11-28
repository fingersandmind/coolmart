<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\Http\Resources\Details\DetailResource;
use App\Http\Resources\Details\DetailsResource;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $details = Detail::with('items')->paginate(10);

        return new DetailsResource($details);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        DetailResource::withoutWrapping();
        return new DetailResource($detail);
    }
}
