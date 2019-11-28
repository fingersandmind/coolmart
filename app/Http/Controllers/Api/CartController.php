<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Http\Resources\Carts\CartResource;
use App\Http\Resources\Carts\CartsResource;
use App\User;
use App\Item;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->authId);

        // $carts = $user->carts;
        $carts = Cart::where('user_id', $user->id)
        ->where('is_checkedout',false)
        ->with('item')->get();

        return new CartsResource($carts);
    }

    public function canBeReviewed(Request $request)
    {
        $user = User::findOrFail($request->authId);
        
        $carts = Cart::where('user_id', $user->id)->checkedout()->with('item')->get();

        return new CartsResource($carts);
    }

    public function show($id)
    {
        CartResource::withoutWrapping();
        $cart = Cart::with(['user','item'])->findOrFail($id);

        return new CartResource($cart);
    }

    /**
     * Check if cart exists and is not checkedout
     * @param App\Item $item
     * @param App\User $user
     * 
     * @return boolean
     */

    public function checkIfCartExists($item, $user, $checkedout = false)
    {
        return Cart::where(['item_id' => $item, 'user_id' => $user, 'is_checkedout' => $checkedout])->exists();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $qty = $request->qty;
        $item = Item::findOrFail($request->itemId);
        $user = User::findOrFail($request->authId);
        $cart = Cart::where(['item_id' => $item->id, 'user_id' => $user->id])->first();
        
        if($this->checkIfCartExists($item->id, $user->id))
        {
            $qty += $cart->qty;
        }

        /**
         * When user click the add to cart button several times, update qty.
         */
        try {
            DB::beginTransaction();

            $user->carts()->updateOrCreate(
                ['item_id' => $item->id, 'user_id' => $user->id, 'is_checkedout' => false],
                [
                    'item_id'   =>  $item->id,
                    'user_id'   =>  $user->id,
                    'qty'       =>  $qty     
                ]
            );

            DB::commit();
    
            return response()->json(['success' => 'Item added to Cart'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
                'code'  => $e->getCode()
            ]);
        }
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
        $cartQty = $cart->validMaxQty($cart->qty);

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
