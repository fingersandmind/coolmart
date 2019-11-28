<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Brand;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::get();

        return view('pages.transactions.create',compact('brands'));
    }
}
