@extends('layouts.app')

@section('title', 'Ajukan Project')

@section('content')

<h3 class="mb-4">Ajukan Project</h3>

<div class="card">
    <div class="card-body">

        <form onsubmit="submitProject(event)">
            @csrf

            <input type="hidden" id="lead_id" value="{{ $leadId }}">

            {{-- Product --}}
            <div class="mb-3">
                <label class="form-label">Produk</label>
                <select class="form-select" id="product_id" required>
                    <option value="">-- Pilih Produk --</option>
                </select>
            </div>

            {{-- Notes --}}
            <div class="mb-3">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea class="form-control" id="notes" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Ajukan Project
            </button>

            <a href="/sales/leads" class="btn btn-secondary ms-2">
                Batal
            </a>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    fetch('/projects/create/{{ $leadId }}', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        const select = document.getElementById('product_id');

        data.products.forEach(product => {
            const option = document.createElement('option');
            option.value = product.id;
            option.textContent = product.product_name;
            select.appendChild(option);
        });
    })
    .catch(() => {
        alert('Gagal memuat produk');
    });
});
</script>
@endpush


@push('scripts')
<script>
function submitProject(event) {
    event.preventDefault();

    fetch('/projects', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            lead_id: document.getElementById('lead_id').value,
            product_id: document.getElementById('product_id').value,
            notes: document.getElementById('notes').value
        })
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Gagal mengajukan project');
        }

        return data;
    })
    .then(() => {
        sessionStorage.setItem(
            'flash_success',
            'Project berhasil diajukan dan menunggu approval manager'
        );

        window.location.replace('/sales/leads');
    })
    .catch(err => {
        alert(err.message);
    });
}
</script>
@endpush
