<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Carts\CartsResource;
use App\Http\Resources\Reviews\ReviewResource;
use App\Item;
use App\Review;
use App\User;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{

    public function show(Request $request, Item $item)
    {
        ReviewResource::withoutWrapping();
        $review = Review::where('user_id', $request->authId)
            ->where('reviewable_id', $item->id)
            ->first();
        return new ReviewResource($review);
    }

    public function checkIfItemExists($item)
    {
        return Cart::where('item_id', $item->id)
        ->where('is_checkedout', true)
        ->exists();
    }

    public function create(Item $item)
    {
        $itemData = [
            'name' => $item->name,
            'image' => $item->images->pluck('images')
        ];
        return $itemData;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::findOrFail($request->authId);
        $item = Item::findOrFail($request->itemId);
        
        try {
            if($this->checkIfItemExists($item))
            {
                $item->reviews()->updateOrCreate(
                    ['user_id' => $user->id, 'reviewable_id' => $item->id],
                    [
                        'user_id' => $user->id,
                        'stars' => $request->stars > 5 ? 5 : $request->stars,
                        'comments' => $request->comments
                    ]
                );

                return response()->json(['message' => 'Thank you for your feedback!']);
            }
            return response()->json(['message' => 'Letson']);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }

    public function toBeReviewed(Request $request)
    {
        $user = User::findOrFail($request->authId);
        $carts = Cart::checkedout()
            ->where('user_id', $user->id)
            ->where('is_cancelled', false)
            ->get();

        return new CartsResource($carts);
    }
}
