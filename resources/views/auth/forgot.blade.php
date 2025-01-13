@extends('layouts.main')

@section('title', 'Forgot password')
@section('content')

    <div class="container_100vh d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="h2 text-center">Восстановление пароля</h1>
                    <form action="{{ route('password.email') }}" method="POST" novalidate>
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Введите емейл для сброса пароля</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary w-100">Send reset request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')

@endsection
