@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="bi bi-door-open"></i> Login Wisma Kita</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Login sebagai</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="account_type" id="admin" value="admin" {{ old('account_type', 'user') === 'admin' ? 'checked' : '' }}>
                                <label class="form-check-label" for="admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="account_type" id="user" value="user" {{ old('account_type', 'user') === 'user' ? 'checked' : '' }}>
                                <label class="form-check-label" for="user">Pelanggan</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username / Email</label>
                            <input type="text" name="identity" class="form-control @error('identity') is-invalid @enderror" value="{{ old('identity') }}" required placeholder="Masukkan username atau email">
                            @error('identity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Masuk</button>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <small class="text-muted">&copy; {{ date('Y') }} Wisma Kita</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection