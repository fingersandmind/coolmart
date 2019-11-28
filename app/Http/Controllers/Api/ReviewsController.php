<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Carts\CartsResource;
use App\Http\Resources\Reviews\ReviewResource;
use App\Item;
use App\Review;
use App\User;
use App\Cart;
use App\Http\Resources\Reviews\ReviewsResource;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{

    public function index(Item $item)
    {
        $reviews = Review::where('reviewable_id', $item->id)->paginate(15);

        return new ReviewsResource($reviews);
    }

    public function show(Request $request, Item $item)
    {
        ReviewResource::withoutWrapping();
        $review = Review::where('user_id', $request->authId)
            ->where('reviewable_id', $item->id)
            ->first();
        return new ReviewResource($review);
    }

    /**
     * Function that check if Cart has that Item and 
     * is checkedout.
     */
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
            'image' => $item->images->pluck('image')
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
        $user = $request->authId;
        $item = Item::findOrFail($request->itemId);
        
        try {
            if($this->checkIfItemExists($item))
            {
                $item->reviews()->updateOrCreate(
                    ['user_id' => $user, 'reviewable_id' => $item->id],
                    [
                        'user_id' => $user,
                        'stars' => $request->stars > 5 ? 5 : $request->stars,
                        'comments' => $request->comments
                    ]
                );

                return response()->json(['message' => 'Thank you for your feedback!']);
            }
            return response()->json(['message' => 'Item you are trying to review is not in the list. Are you a hacker?']);
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
