<?php

namespace App\PurchaseOrder;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    const COMPANY = 'AllCool Advanced Cooling System';
    const ADDRESS = 'Unit G 2/F TSP Bldg.,Km. 30 National Road Tunasan, Muntinlupa City 1773, NCR, Philippines';
    const REMARKS = 'STOCKS, PLEASE ATTACH P.O UPON DELIVERY, CALL OUR AC/WAREHOUSE PERSONNEL BEFORE DELIVERY.';
    const EMAIL = 'allcoolph.com';
    const INFO = 'Tel:#:(02) 7792-2656 fb-page:facebook.com/allcoolph/';

    protected $fillable = [
        'company', 'ref_no', 'supplier', 'term', 'delivery_date', 'po_valid', 'ship_to',
        'location', 'remarks', 'preparedBy', 'notedBy', 'approvedBy', 'user_id'
    ];

    public function getPurchaseCodeAttribute()
    {
        return str_pad($this->id+1000,6,'0',STR_PAD_LEFT);
    }

    public function email()
    {
        return self::EMAIL;
    }

    public function info()
    {
        return self::INFO;
    }

    public function company()
    {
        return self::COMPANY;
    }

    public function address()
    {
        return self::ADDRESS;
    }

    public function remarks()
    {
        return self::REMARKS;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dated()
    {
        return Carbon::parse(now());
    }

    public function deliveryDate($options = null)
    {
        $days = $options != null ? $options : 3;
        return $this->dated()->addDays($days);
    }

    public function poValidDate($options = null)
    {
        $month = $options != null ? $options : 1;

        return $this->dated()->addMonths($month);
    }

    public function totalItems()
    {
        $total = 0;
        if($this->orders)
        {
            foreach($this->orders as $order)
            {
                $total += $order->qty;
            }
        }

        return $total;
    }

    public function totalNetAmount()
    {
        $totalOrdersAmount = 0;
        if($this->orders)
        {
            foreach($this->orders as $order)
            {
                $orderTotal = $order->item->net * $order->qty;
                $totalOrdersAmount += $orderTotal;
            }
        }

        return $totalOrdersAmount;
    }

    public function vatTotalDue()
    {
        $vat = 12;
        $totalVatAmount = ($vat/100) * $this->totalNetAmount();

        return $totalVatAmount;
    }

    public function totalPOAmount()
    {
        $po_amount = $this->totalNetAmount() - $this->vatTotalDue();

        return $po_amount;
    }

    public function createPurchaseOrder()
    {
        $details = session('details');
        $orders = session('orders');
        if($orders)
        {
            $po = $this->create([
                'company'       =>  $this->company(),
                'ref_no'        =>  $details['ref_no'],
                'supplier'      =>  $details['supplier'],
                'term'          =>  $details['term'],
                'delivery_date' =>  $this->deliveryDate(),
                'po_valid'      =>  $this->poValidDate(),
                'ship_to'       =>  $details['ship_to'],
                'location'      =>  $details['location'],
                'remarks'       =>  $details['remarks'],
                'preparedBy'    =>  $details['preparedBy'],
                'notedBy'       =>  $details['notedBy'],
                'approvedBy'    =>  $details['approvedBy'],
                'user_id'       =>  auth()->user()->id
            ]);
    
            foreach($orders as $order)
            {
                if($order['qty'] > 0)
                {
                    $po->orders()->create(['item_id' => $order['id'], 'qty' => $order['qty']]);
                }
            }
        }

        session()->forget(['orders', 'details']);
    }

    public function sessionStore($request)
    {
        $details = session('details');
        $detail = [
            'company'       =>  $this->company(),
            'ref_no'        =>  $request->has('ref_no') ? $request->ref_no : 'none',
            'supplier'      =>  $request->supplier,
            'term'          =>  $request->has('term') ? $request->term : 'none',
            'delivery_date' =>  $this->deliveryDate(),
            'po_valid'      =>  $this->poValidDate(),
            'ship_to'       =>  $request->ship_to,
            'location'      =>  $request->location,
            'remarks'       =>  $request->remarks,
            'preparedBy'    =>  $request->preparedBy,
            'notedBy'       =>  $request->notedBy,
            'approvedBy'    =>  $request->approvedBy,
            'user_id'       =>  auth()->user()->id
        ];

        if(!$details)
        {
            $details = $detail;
            session()->put('details', $details);
        }

        if(!isset($details))
        {
            $details = $detail;
            session()->put('details', $details);
        }
    }
}
