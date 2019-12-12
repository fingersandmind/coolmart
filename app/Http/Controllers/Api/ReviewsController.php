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

    public function show(Item $item)
    {
        $user = auth('api')->user();   
        $review = $user->reviews()
            ->where('reviewable_id', $item->id)
            ->first();
            
        $data['name'] = $item->name;
        $data['image'] = $item->images->pluck('thumbnail');
        $data['item_id'] = $item->id;
        $data['review_stars'] = $review->stars;
        $data['review_comment'] = $review->comments;

        return $data;
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
        $user = auth('api')->user();
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
            return response()->json(['message' => 'Item you are trying to review is not in the list. Are you a hacker?']);
        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        }
    }

    public function toBeReviewed()
    {
        $user = auth('api')->user();
        $itemIds = $user->reviews->pluck('reviewable_id');

        $carts = $user->carts()->checkedout()
            ->whereNotIn('item_id',$itemIds)
            ->get();

        return new CartsResource($carts->unique('item_id')->paginate(5));
    }

    public function withReview(Request $request)
    {
        $userId = auth('api')->user()->id;
        
        $items = Item::whereHas('reviews')
        ->with(['reviews' => function($q) use($userId){
            $q->where('user_id',$userId);
        }])
        ->with(['carts' => function($c) use($userId){
            $c->where('user_id', $userId);
        }])
        ->get()
        ->sortByDesc(function($q){
            return $q->reviews()->orderBy('reviews.updated_at');
        });

        return $this->reviewedItemsCollection($items);
    }

    public function reviewedItemsCollection($items)
    {
        $array = [];
        foreach($items as $item)
        {
            $arr['name']    = $item->name;
            $arr['slug']    = $item->slug;
            $arr['id']      = $item->id;
            $arr['image']   = $item->images->pluck('thumbnail');
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
