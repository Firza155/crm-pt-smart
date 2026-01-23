@extends('layouts.app')

@section('title', 'Edit Lead')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sales.css') }}">
@endpush

@section('content')
    <h3 class="mb-4">Edit Lead</h3>

    {{-- Jika lead sudah bukan status new --}}
    @if($lead->status !== 'new')
        <div class="alert alert-warning">
            Lead ini tidak dapat diedit karena sudah diproses.
        </div>

        <a href="{{ url('/sales/leads') }}" class="btn btn-secondary">
            Kembali
        </a>
    @else
        <div class="card">
            <div class="card-body">

                {{-- Error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form edit --}}
                <form action="/leads/{{ $lead->id }}" method="POST" onsubmit="updateLead(event)">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $lead->name) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $lead->phone) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $lead->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="address"
                                  class="form-control"
                                  rows="3">{{ old('address', $lead->address) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ url('/sales/leads') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </form>

            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
function updateLead(event) {
    event.preventDefault();

    const form = event.target;

    fetch(form.action, {
        method: 'POST', // tetap POST karena Laravel spoof PUT
        headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(() => {
        // simpan pesan sukses sementara
        sessionStorage.setItem('flash_success', 'Lead berhasil diperbarui');

        // redirect bersih ke daftar lead
        window.location.replace('/sales/leads');
    })
    .catch(() => {
        alert('Gagal memperbarui lead');
    });
}
</script>
@endpush
