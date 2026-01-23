@extends('layouts.auth')

@section('title', 'Login | CRM PT Smart')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-card-header">
            Login CRM PT Smart
        </div>

        <div class="auth-card-body">
            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
