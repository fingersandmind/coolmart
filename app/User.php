<?php

namespace App;

use App\PurchaseOrder\Purchase;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}