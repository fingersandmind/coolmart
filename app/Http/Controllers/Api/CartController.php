<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Http\Resources\Carts\CartResource;
use App\Http\Resources\Carts\CartsResource;
use App\Item;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $carts = $user->carts()
            ->where('is_checkedout', false)
            ->with(['item', 'service'])
            ->get();

        return new CartsResource($carts);
    }

    public function show($id)
    {
        CartResource::withoutWrapping();
        $cart = Cart::with(['user','item'])->findOrFail($id);

        return new CartResource($cart);
    }

    public function getValidQty($qty, $validQty)
    {
        return $qty > $validQty ? $validQty : $qty;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();
        $item = Item::findOrFail($request->itemId);
        $cart = $user->carts()->where('item_id', $item->id)->first();
        $qty = $request->qty;
        if($cart)
        {
            if($request->service_name)
            {
                $cart->update(['qty' => $qty]);
                $cart->addCartService($cart, $request);
                return response()->json(['success' => 'Item Cart updated!'], 200);
            }
            $cart->update(['qty' => $qty]);
            $cart->service()->delete();
            return response()->json(['success' => 'Item Cart updated!'], 200);
        }
        $qty += $cart->qty ?? 0;
        
        $user->addCart($request, $this->getValidQty($qty, $item->qty));

        return response()->json(['success' => 'Item added to Cart'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        CartResource::withoutWrapping();

        return new CartResource($cart);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        /**
         * Qty will be based on available stock of an item.
         */
        $cartQty = $cart->validMaxQty();

        if($request->get('action') == 'addQty')
        {
            $cartQty++;
            $cart->update(['qty' => $cartQty]);
            return response()->json(['success' => 'Cart updated!'], 200);
        }elseif($request->get('action') == 'deductQty')
        {
            $cartQty--;
            $cart->update(['qty' => $cartQty]);
            return response()->json(['success' => 'Cart updated!'], 200);
        }
    }

    public function removeService(Cart $cart)
    {
        $cart->service()->delete();
        return response()->json(['message' => 'Successfully removed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(['success' => 'Cart deleted!'], 200);
    }
}
