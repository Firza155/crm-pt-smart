@extends('layouts.app')

@section('title', 'Approval Project')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/manager.css') }}">
@endpush

@section('content')
<h3 class="mb-4">Approval Project</h3>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Lead</th>
                        <th>Produk</th>
                        <th>Kecepatan</th>
                        <th>Harga</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody id="project-table-body">
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Memuat data project...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    loadProjects();
});

function loadProjects() {
    fetch('/projects', { headers: { 'Accept': 'application/json' } })
        .then(res => res.json())
        .then(projects => {
            const tbody = document.getElementById('project-table-body');
            tbody.innerHTML = '';

            if (projects.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada project pending
                        </td>
                    </tr>
                `;
                return;
            }

            projects.forEach(project => {
                tbody.innerHTML += `
                    <tr>
                        <td>${project.lead.name}</td>
                        <td>${project.product.product_name}</td>
                        <td>${project.product.speed} Mbps</td>
                        <td>Rp ${formatPrice(project.product.price)}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm"
                                    onclick="approveProject(${project.id})">
                                    Approve
                                </button>

                                <button class="btn btn-danger btn-sm"
                                    onclick="rejectProject(${project.id})">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        });
}

function approveProject(id) {
    if (!confirm('Yakin ingin menyetujui project ini?')) return;

    sendAction(`/projects/${id}/approve`, 'Project berhasil disetujui');
}

function rejectProject(id) {
    if (!confirm('Yakin ingin menolak project ini?')) return;

    sendAction(`/projects/${id}/reject`, 'Project berhasil ditolak');
}

function sendAction(url, successMessage) {
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Terjadi kesalahan');
        }

        sessionStorage.setItem('flash_success', successMessage);
        window.location.reload();
    })
    .catch(err => {
        sessionStorage.setItem('flash_error', err.message);
        window.location.reload();
    });
}


function formatPrice(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}
</script>
@endpush
