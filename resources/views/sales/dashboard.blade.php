@extends('layouts.app')

@section('title', 'Dashboard Sales')

@section('content')

<h3 class="mb-4">Dashboard Sales</h3>

<div class="alert alert-info">
    Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
    Gunakan menu di bawah untuk mengelola lead Anda.
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Daftar Lead</h5>
                <p class="card-text">
                    Lihat semua lead yang telah Anda input.
                </p>
                <a href="{{ url('/sales/leads') }}" class="btn btn-primary">
                    Lihat Lead
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Tambah Lead</h5>
                <p class="card-text">
                    Tambahkan calon customer baru ke sistem.
                </p>
                <a href="{{ url('/sales/leads/create') }}" class="btn btn-outline-primary">
                    Tambah Lead
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
