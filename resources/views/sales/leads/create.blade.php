@extends('layouts.app')

@section('title', 'Tambah Lead')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sales.css') }}">
@endpush

@section('content')
    <h3 class="mb-4">Tambah Lead Baru</h3>

    <div class="card">
        <div class="card-body">

            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form create lead --}}
            <form onsubmit="handleSubmit(event)">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text"
                           name="phone"
                           class="form-control"
                           value="{{ old('phone') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (Opsional)</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat (Opsional)</label>
                    <textarea name="address"
                              class="form-control"
                              rows="3">{{ old('address') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ url('/sales/dashboard') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
<script>
function handleSubmit(event) {
    event.preventDefault();

    const form = event.target;

    fetch('/leads', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content'),
            'Accept': 'application/json'
        },
        body: new FormData(form)
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Gagal menyimpan lead');
        }

        sessionStorage.setItem(
            'flash_success',
            'Lead berhasil ditambahkan ke sistem'
        );

        window.location.replace('/sales/dashboard');
    })
    .catch(error => {
        sessionStorage.setItem(
            'flash_error',
            error.message || 'Gagal menyimpan lead. Periksa kembali input Anda.'
        );

        window.location.reload();
    });
}
</script>
@endpush
