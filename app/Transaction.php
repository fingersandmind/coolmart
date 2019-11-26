<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{

    protected $fillable = ['user_id'];

    public function getTransactionCodeAttribute()
    {
        return str_pad($this->id+1000, 8,'0',STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function makeTransaction($ids)
    {
        try {
            DB::beginTransaction();

            Cart::whereIn('id',$ids)->update([
                'is_checkedout' => true,
                'transaction_id' => $this->id
                ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
