<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //Menyimpan user baru (sales / manager).
    public function store(Request $request)
    {
        // Validasi input user
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:sales,manager'
        ]);

        // Hash password otomatis
        $data['password'] = Hash::make($data['password']);

        // Simpan user ke database
        $user = User::create($data);

        return response()->json([
            'message' => 'User berhasil dibuat',
            'data'    => $user
        ], 201);
    }
}
