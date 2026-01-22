<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Model Project untuk pengajuan layanan oleh Sales
class Project extends Model
{
    use HasFactory;
    
    //Kolom utama project.
    protected $fillable = [
        'lead_id', 'product_id', 'status', 'notes',
        'approved_by', 'approved_at'
    ];

    //Relasi ke lead.
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    //Relasi ke produk yang diajukan.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Relasi ke manager yang melakukan approval.
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
