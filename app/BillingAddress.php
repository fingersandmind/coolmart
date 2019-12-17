<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $table = 'billing_addresses';

    protected $fillable = ['user_id', 'fullname', 'contact', 'other_notes', 'building', 'province', 'city', 'brgy', 'type', 'is_shipping', 'is_billing'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProvinceNameAttribute()
    {
        return $this->explodedValue($this->province)[1];
    }

    public function getCityNameAttribute()
    {
        return $this->explodedValue($this->city)[1];
    }

    public function getBarangayNameAttribute()
    {
        return $this->explodedValue($this->brgy)[1];
    }

    public function explodedValue($string)
    {
        $data = explode('--', $string);
        return $data;
    }

    public function updateBillingToDefault()
    {
        BillingAddress::where('user_id', $this->user->id)
                ->update(['is_billing' => false]);

        $this->update(['is_billing' => true]);
    }

    public function updateShippingToDefault()
    {
        BillingAddress::where('user_id', $this->user->id)
                ->update(['is_shipping' => false]);

        $this->update(['is_shipping' => true]);
    }

    public function getAddressDetailsAttribute()
    {
        return $this->building.','.$this->BarangayName.','.$this->CityName.','.$this->ProvinceName;
    }

    public function defaultShippingPostCode()
    {
        return $this->fullname.'--'.$this->postCode().'--'.$this->contact;
    }

    public function defaultBillingPostCode()
    {
        return $this->fullname.'--'.$this->postCode().'--'.$this->contact;
    }

    public function postCode()
    {
        return $this->BarangayName. ', ' . $this->CityName . ', ' . $this->ProvinceName;
    }
}
