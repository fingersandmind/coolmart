<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\AirconList;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\PurchaseOrder\Purchase;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pos = Purchase::get();

        return view('pages.purchases.index', compact('pos'));
    }
    public function create()
    {
        $data = new Purchase();

        return view('pages.purchases.create', compact('data'));
    }
    /**
     * Validate request then store to session for preview purposes
     */

    public function store(PurchaseRequest $request)
    {
        $request->validated();
        $po = new Purchase();

        $po->sessionStore($request);
        
        return redirect()->route('order.add');
    }

    /**
     * Display P O Details and Item added Details
     * Serves as create view function
     */

    public function addItems()
    {
        $details = session('details');
        $orders = session()->has('orders') ? session('orders') : null;
        $lists = AirconList::get();
        // dd($orders);
        return view('pages.purchases.addItems',compact('lists', 'details','orders'));
    }

    /**
     * Store now session(['orders','details']) to database
     */

    public function storePurchaseOrder(Request $request)
    {
        if($request->action == 'submit')
        {
            $orders = session('orders');
            if($orders)
            {
                if($this->orderQty() > 0)
                {
                    $po = new Purchase();
                    $po->createPurchaseOrder();
                    return redirect()->route('dashboard')->withSuccess('P.O Successfully Created!');
                }
                return redirect()->back()->withError('Please atleast have an item with 1 quantity');
            }

            return redirect()->back()->withError('Please supply an Item');
        }elseif($request->action == 'cancel')
        {
            session()->forget(['orders', 'details']);
            return redirect()->route('dashboard');
        }
    }

    public function orderQty()
    {
        $orders = session('orders');
        $total = 0;

        if($orders)
        {
            foreach($orders as $order)
            {
                $total += $order['qty'];
            }
        }
        return $total;
    }
    /**
     * Store items in session and can update quantity
     * @param Request $request
     * @param value = ItemCode
     */

    public function storeItems(Request $request)
    {
        if($request->plus || $request->minus)
        {
            $this->updateItemQty($request);
            return redirect()->back();
        }
        $item = AirconList::findOrFail($request->action);
        
        $item->sessionStore($request);
        return redirect()->back();
        
    }
    /**
     * @param Item_Code
     * Function to update quantity of items in session
     */

    public function updateItemQty($request)
    {
        $orders = session('orders');
        if($request->plus)
        {
            $net = floatval(str_replace(',','',$orders[$request->plus]['net']));
            $orders[$request->plus]['qty'] ++;
            $orders[$request->plus]['total'] = number_format($net * $orders[$request->plus]['qty'],2);
            session()->put('orders', $orders);
        }elseif($request->minus)
        {
            if($orders[$request->minus]['qty'] > 0)
            {
                $net = floatval(str_replace(',','',$orders[$request->minus]['net']));
                $orders[$request->minus]['qty'] --;
                $orders[$request->minus]['total'] = number_format($net * $orders[$request->minus]['qty'],2);
                session()->put('orders', $orders);
            }
        }
    }

    public function showPurchaseOrder(Purchase $purchase)
    {
        return view('invoice.purchase-order', compact('purchase'));
    }

    public function showSession()
    {
        return session()->all();
    }
}
