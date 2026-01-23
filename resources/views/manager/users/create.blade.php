@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<h3 class="mb-4">Tambah User</h3>

<div id="flash-message"></div>

<div class="card">
    <div class="card-body">

        <form onsubmit="submitUser(event)">
            @csrf

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" id="name" class="form-control" required>
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" class="form-control" required>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" class="form-control" required>
            </div>

            {{-- Role --}}
            <div class="mb-3">
                <label class="form-label">Role</label>
                <select id="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="sales">Sales</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan User
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
function submitUser(event) {
    event.preventDefault();

    fetch('/manager/users', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            role: document.getElementById('role').value,
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal membuat user');

        sessionStorage.setItem('flash_success', 'User berhasil dibuat');
        window.location.replace('/manager/dashboard');
    })
    .catch(err => {
        alert(err.message);
    });
}
</script>
@endpush
