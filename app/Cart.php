<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    protected $fillable = ['item_id', 'qty', 'user_id', 'transaction_id', 'status'];
    const PROCESSING = 1;
    const SHIPPED = 2;
    const DELIVERED = 3;
    const PENDING = 4;
    const CANCELLED = 5;
    const REFUNDED = 6;
    const RETURNED = 7;
    const REPLACED = 8;

    protected $statusArr = [
        'Processing' => self::PROCESSING, 'Shipped' => self::SHIPPED, 'Delivered' => self::DELIVERED,
        'Pending' => self::PENDING, 'Cancelled' => self::CANCELLED, 'Refunded' => self::REFUNDED,
        'Returned' => self::RETURNED,'Replaced' => self::REFUNDED
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    public function scopeCheckedout($query)
    {
        return $query->where('is_checkedout', true);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function scopeUnCheckedout($query)
    {
        return $query->where('is_checkedout', false);
    }

    /**
     * Check if a cart which status is PENDING or PROCESSING is valid for cancel.
     */
    public function cancellable()
    {
        $date_placed = Carbon::parse($this->created_at);
        $is_cancellable = in_array($this->statusArr[$this->status], [self::PENDING, self::PROCESSING]);
        $is_over =  $this->created_at < $date_placed->addDay() ? true : false;

        if($is_cancellable AND $is_over)
        {
            return true;
        }
        return false;
    }

    /**
     * Check if a cart which status is DELIVERED is valid for return.
     */
    public function returnable()
    {
        $date_placed = Carbon::parse($this->updated_at);
        $is_returnable = $this->statusArr[$this->status] == self::DELIVERED ? true : false;
        $is_over =  $this->updated_at < $date_placed->addWeek() ? true : false;

        if($is_returnable AND $is_over)
        {
            return true;
        }
        return false;
    }

    /**
     * Maximum cart qty must not exceed item qty
     * If cart qty is over item qty, item qty must return
     * 
     */
    public function validMaxQty()
    {
        return $this->qty > $this->item->qty ? $this->item->qty : $this->qty;
    }

    /**
     * Return cart subtotal of PENDING carts
     */
    public function cartTotal()
    {
        $total =  $this->item->accuratePrice() * $this->validMaxQty();
        return $total;
    }

    /**
     * Return subtotal of carts that are already checkedout.
     */
    public function checkedoutSubTotal()
    {
        return $this->item->accuratePrice() * $this->qty;
    }

    /**
     * Return cart subtotal plus cart that has service fee
     */
    public function getSubtotalWithServiceTotal()
    {
        return $this->getServiceTotal() + $this->cartTotal();
    }

    /**
     * Get the additional services details of a cart;
     */
    public function getServiceDetails()
    {
        if($this->service)
        {
            $data['item_standard_installation_fee'] = $this->item->standard_install_fee;
            $data['standard_feet'] = 10;
            $data['excess_charge_per_feet'] = (string)300;
            $data['total_feet'] = $this->service->value;
            $data['service_id'] = $this->service->id;
            $data['name'] = $this->service->name;
            $data['total'] = $this->getServiceTotal();
            return $data;
        }
        return null;
    }

    /**
     * Return total of service of particular cart that has a service.
     */
    public function getServiceTotal()
    {
        $total = 0;
        if($this->service)
        {
            $installation_fee = $this->item->standard_install_fee;
            $feet = $this->service->value;
            $excessFeet = $feet - 10;
            $feePerExcess = $excessFeet * 300;
            $total = $installation_fee + $feePerExcess;
        }
        return $total;
    }

    /**
     * Add a service to the cart.
     */
    public function addCartService($cart, $request)
    {
        $cart->service()->updateOrCreate(
            ['cart_id' => $cart->id],
            [
                'name' => $request->service_name,
                'value' => $request->value
            ]
        );
    }











































    
    // public function persists($request, $qty)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $cart = $this->updateOrCreate(
    //             ['item_id' => $request->itemId, 'user_id' => $this->user->id, 'is_checkedout' => false],
    //             [
    //                 'item_id'   =>  $request->itemId,
    //                 'user_id'   =>  $this->user->id,
    //                 'qty'       =>  $qty,
    //                 'status' => self::PENDING
    //             ]
    //         );

    //         if(!$request->service_name == null)
    //         {
    //             $this->addCartService($cart,$request);
    //         }
    //         DB::commit();
    //     } catch (\Throwable $th) {
    //         DB::rollBack();

    //         return response()->json([
    //             'error' => $th->getMessage(),
    //             'code'  => $th->getCode()
    //         ]);
    //     }
        
    // }
    
}
