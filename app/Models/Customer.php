<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //Kolom data customer.
    protected $fillable = [
        'lead_id', 'name', 'phone', 'email', 'address'
    ];

    //Relasi ke lead asal.
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    //Relasi ke layanan customer.
    public function services()
    {
        return $this->hasMany(CustomerService::class);
    }
}
