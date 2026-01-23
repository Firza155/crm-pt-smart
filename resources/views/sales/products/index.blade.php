@extends('layouts.app')

@section('title', 'Daftar Produk')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/sales.css') }}">
@endpush

@section('content')
<h3 class="mb-4">Daftar Produk Layanan</h3>

<div class="card">
    <div class="card-body">

        @if($products->isEmpty())
            <div class="alert alert-info">
                Belum ada produk tersedia.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kecepatan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->speed }} Mbps</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
