@extends('layouts.app')

@section('title', 'Daftar Lead')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sales.css') }}">
@endpush

@section('content')
    {{-- Judul halaman --}}
    <h3 class="mb-4">Daftar Lead</h3>

    {{-- Card container --}}
    <div class="card">
        <div class="card-body">

            {{-- Jika belum ada lead --}}
            @if($leads->isEmpty())
                <div class="alert alert-info">
                    Belum ada lead. Silakan tambahkan lead baru.
                </div>
            @else
                {{-- Table lead --}}
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="220">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="lead-table-body">
                            <tr id="loading-row">
                                <td colspan="5" class="text-center text-muted">
                                    Memuat data lead...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
<script>
function deleteLead(id) {
    if (!confirm('Yakin ingin menghapus lead ini?')) return;

    fetch(`/leads/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(() => {
        // Simpan pesan sukses sementara
        sessionStorage.setItem('flash_success', 'Lead berhasil dihapus');

        // Redirect TANPA query string & TANPA history tambahan
        window.location.replace('/sales/leads');
    })
    .catch(() => {
        alert('Gagal menghapus lead');
    });
}
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    loadLeads();
});

function loadLeads() {
    fetch('/leads', { headers: { 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(leads => {
            const tbody = document.getElementById('lead-table-body');
            tbody.innerHTML = '';

            if (leads.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada lead
                        </td>
                    </tr>
                `;
                return;
            }

            leads.forEach(lead => {
                tbody.innerHTML += `
                    <tr>
                        <td>${lead.name}</td>
                        <td>${lead.phone}</td>
                        <td>${lead.email ?? '-'}</td>
                        <td>${renderStatus(lead.status)}</td>
                        <td>${renderAction(lead)}</td>
                    </tr>
                `;
            });
        });
}

function renderStatus(status) {
    switch (status) {
        case 'new':
            return '<span class="badge bg-primary">New</span>';
        case 'on_progress':
            return '<span class="badge bg-warning text-dark">On Progress</span>';
        case 'converted':
            return '<span class="badge bg-success">Converted</span>';
        case 'rejected':
            return '<span class="badge bg-danger">Rejected</span>';
        default:
            return '-';
    }
}

function renderAction(lead) {
    if (lead.status !== 'new') {
        return '<span class="text-muted small">Tidak ada aksi</span>';
    }

    return `
        <div class="d-flex flex-column gap-1">
            <a href="/sales/leads/${lead.id}/edit"
               class="btn btn-warning btn-sm">
                Edit
            </a>

            <button onclick="deleteLead(${lead.id})"
                    class="btn btn-danger btn-sm">
                Hapus
            </button>

            <a href="/sales/projects/create/${lead.id}"
               class="btn btn-primary btn-sm">
                Ajukan Project
            </a>
        </div>
    `;
}
</script>
@endpush

