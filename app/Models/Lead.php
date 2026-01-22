<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasFactory;
    
    //Kolom yang boleh diisi melalui form.
    protected $fillable = [
        'name', 'phone', 'email', 'address', 'status', 'created_by'
    ];

    //Relasi ke user (sales).
    public function sales()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //Relasi ke project pengajuan layanan.
    public function project()
    {
        return $this->hasOne(Project::class);
    }

    //Relasi ke customer aktif.
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
}
