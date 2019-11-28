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
        $reviews = Review::where('reviewable_id', $item->id)->paginate(8);

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
        $items = $user->reviews->pluck('reviewable_id');
        $carts = Cart::checkedout()
            ->whereNotIn('item_id',$items)
            ->where('user_id', $user->id)
            ->where('is_cancelled', false)
            ->paginate(5);

        return new CartsResource($carts);
    }

    public function withReview(Request $request)
    {
        $userId = User::findOrFail($request->authId)->id;
        
        $items = Item::whereHas('reviews')
        ->with(['reviews' => function($q) use($request){
            $q->where('user_id',$request->authId);
        }])
        ->with(['carts' => function($c) use($userId){
            $c->where('user_id', $userId);
        }])
        ->get();

        return $this->reviewedItemsCollection($items);
    }

    public function reviewedItemsCollection($items)
    {
        $array = [];
        foreach($items as $item)
        {
            $arr['name'] = $item->name;
            $arr['slug'] = $item->slug;
            $arr['image'] = $item->images->pluck('thumbnail');
            foreach($item->carts as $cart)
            {
                $arr['date_placed'] = $cart->updated_at->toFormattedDateString();
            }
            foreach($item->reviews as $review)
            {
                $arr['star'] = $review->stars;
                $arr['comment'] = $review->comments;
            }

            array_push($array, $arr);
        }

        $collection = collect($array);

        return $collection->paginate(5);
    }
}
