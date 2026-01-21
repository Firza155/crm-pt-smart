<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerService extends Model
{
    //Kolom data layanan.
    protected $fillable = [
        'customer_id', 'product_id', 'start_date', 'status'
    ];

    //Relasi ke customer.
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //Relasi ke produk layanan.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
