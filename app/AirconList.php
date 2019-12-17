<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirconList extends Model
{
    protected $table = 'aircon_lists';
    protected $fillable = ['brand_id', 'type', 'model', 'description', 'net'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getListItemCodeAttribute()
    {
        return str_pad($this->id+1000, 6, '0', STR_PAD_LEFT);
    }

    public function sessionStore($request)
    {
        $key = (string)$this->ListItemCode;
        $orders = session('orders');
        $order = [
            'id' => $this->id,
            'item_code' => $key,
            'model' =>  $this->model,
            'net'   =>  number_format($this->net,2),
            'qty'   =>  0,
            'total' => '0'
        ];

        if(!$orders)
        {
            $orders[$key] = $order;
            $orders[$key]['total'] = $this->net;
            session()->put('orders', $orders);
        }

        if(isset($orders[$key]))
        {
            $orders[$key]['qty']++;
            $orders[$key]['total'] = number_format($this->net * $orders[$key]['qty'],2);
            session()->put('orders', $orders);
        }else{
            $orders[$key] = $order;
            $orders[$key]['qty']++;
            $orders[$key]['total'] = number_format($this->net * $orders[$key]['qty'],2);
            session()->put('orders', $orders);
        }
    }
}
