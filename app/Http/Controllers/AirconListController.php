<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AirconList;

class AirconListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lists = AirconList::get();

        return view('pages.supplier.index', compact('lists'));
    }
}
