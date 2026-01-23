@extends('layouts.app')

@section('title', 'Riwayat Project')

@section('content')
<h3 class="mb-4">Riwayat Project</h3>

{{-- PROJECT APPROVED --}}
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        Project Approved
    </div>
    <div class="card-body">

        @if($approved->isEmpty())
            <p class="text-muted mb-0">Belum ada project approved.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Lead</th>
                            <th>Produk</th>
                            <th>Kecepatan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approved as $project)
                            <tr>
                                <td>{{ $project->lead->name }}</td>
                                <td>{{ $project->product->product_name }}</td>
                                <td>{{ $project->product->speed }} Mbps</td>
                                <td>Rp {{ number_format($project->product->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>

{{-- PROJECT REJECTED --}}
<div class="card">
    <div class="card-header bg-danger text-white">
        Project Rejected
    </div>
    <div class="card-body">

        @if($rejected->isEmpty())
            <p class="text-muted mb-0">Belum ada project rejected.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Lead</th>
                            <th>Produk</th>
                            <th>Kecepatan</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejected as $project)
                            <tr>
                                <td>{{ $project->lead->name }}</td>
                                <td>{{ $project->product->product_name }}</td>
                                <td>{{ $project->product->speed }} Mbps</td>
                                <td>Rp {{ number_format($project->product->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>
@endsection
