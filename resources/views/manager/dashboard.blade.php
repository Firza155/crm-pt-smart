@extends('layouts.app')

@section('title', 'Dashboard Manager')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/manager.css') }}">
@endpush

@section('content')
<h3 class="mb-4">Dashboard Manager</h3>

<div class="row g-3 mb-4">
    {{-- Pending --}}
    <div class="col-md-4">
        <div class="card border-warning">
            <div class="card-body">
                <h6 class="text-muted">Project Pending</h6>
                <h3 id="pending-count">{{ $pendingCount }}</h3>
            </div>
        </div>
    </div>

    {{-- Approved --}}
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body">
                <h6 class="text-muted">Project Approved</h6>
                <h3 id="approved-count">{{ $approvedCount }}</h3>
            </div>
        </div>
    </div>

    {{-- Rejected --}}
    <div class="col-md-4">
        <div class="card border-danger">
            <div class="card-body">
                <h6 class="text-muted">Project Rejected</h6>
                <h3 id="rejected-count">{{ $rejectedCount }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-1">Approval Project</h5>
            <p class="text-muted mb-0">
                Kelola pengajuan project dari Sales
            </p>
        </div>
        <a href="/manager/projects" class="btn btn-primary">
            Lihat Project Pending
        </a>
    </div>
</div>
@endsection
