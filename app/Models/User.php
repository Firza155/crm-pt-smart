<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//Model User untuk user internal (sales dan manager).
class User extends Authenticatable
{
    //Relasi ke lead yang dibuat oleh sales.
    public function leads()
    {
        return $this->hasMany(Lead::class, 'created_by');
    }

     //Relasi ke project yang di-approve oleh manager.
    public function approvedProjects()
    {
        return $this->hasMany(Project::class, 'approved_by');
    }

    //Kolom yang boleh diisi saat create user.
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];
}
