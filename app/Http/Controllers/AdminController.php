<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UpdateListTrait;
use App\AirconList;
use App\Brand;
use App\Item;
use App\PurchaseOrder\Purchase;
use App\User;

class AdminController extends Controller
{
    use UpdateListTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brandCount = Brand::count();
        $itemCount = Item::count();
        $userCount = User::count();
        $itemLessThanFive = Item::qtyLessThanFive()->get();
        $pos = Purchase::get();
        $lists = AirconList::get();
        return view('pages.index', compact('brandCount', 'itemCount', 'userCount', 'pos', 'lists', 'itemLessThanFive'));
    }

    /**
     * Update list using api call
     * 
     * @return \Illuminate\Http\Response
     */
    
    public function loadAll()
    {
        $this->loadBrand();
        sleep(1);
        $this->loadList();
        sleep(1);
        $this->loadType();
        sleep(1);
        $this->loadCategory();
        sleep(1);
        $this->loadItem();
        
        return redirect()->back()->withSuccess('List successfully updated!');
    }

}
