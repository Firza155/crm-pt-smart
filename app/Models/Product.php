<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //Kolom yang dapat dikelola dari halaman master produk.
    protected $fillable = [
        'product_name', 'speed', 'price', 'description'
    ];

    //Relasi ke project yang menggunakan produk ini.
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    //Relasi ke layanan customer.
    public function customerServices()
    {
        return $this->hasMany(CustomerService::class);
    }
}
