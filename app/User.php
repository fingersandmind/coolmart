<?php

namespace App;

use App\PurchaseOrder\Purchase;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;
    const ADMIN = 1;
    const USER = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->is_admin == self::ADMIN;
    }

    public function isPurchased($item)
    {
        $purchased = 0;
        if($this->carts)
        {
            foreach($this->carts as $cart)
            {
                if($cart->item->slug == $item && $cart->is_checkedout == true)
                {
                    $purchased = 1;
                }
            }
        }
        return $purchased;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Cart function returns carted items
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * 
     ****** [For Purchase Order Only(backend)]  *******
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    /**
     * 
     ****** [For Purchase Order Only(backend)]  *******
     */


    public function billingAddresses()
    {
        return $this->hasMany(BillingAddress::class, 'user_id');
    }

    public function cancellations()
    {
        return $this->hasMany(Cancellation::class);
    }

    public function defaultShippingAddress()
    {
        return $this->billingAddresses()->where('is_shipping', true)->first();
    }

    public function defaultBillingAddress()
    {
        return $this->billingAddresses()->where('is_billing', true)->first();
    }

    public function makeTransaction()
    {
        try {
            DB::beginTransaction();

            if(count($this->carts()->unCheckedOut()->get()) > 0)
            {
                $transaction = $this->transactions()->create([
                    'ship_post_code' => $this->defaultShippingAddress()->defaultShippingPostCode(),
                    'bill_post_code' => $this->defaultBillingAddress()->defaultBillingPostCode(),
                ]);
        
                $this->carts()->where('is_checkedout', false)
                    ->update([
                        'transaction_id' => $transaction->id, 
                        'is_checkedout' => true,
                        'status' => Cart::PENDING
                        ]);
            }
            DB::commit();

            return response()->json([
                'transaction_id' => $transaction->id,
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ]);
        }
    }

}