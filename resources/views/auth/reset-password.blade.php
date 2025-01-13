@extends('layouts.main')

@section('title', 'Reset password')
@section('content')

    <div class="container_100vh d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="h2">Reset password</h1>

                    <form action="{{ route('password.update') }}" method="post">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" id="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                id="password_confirmation">
                        </div>

                        <button type="submit" class="btn btn-primary">Reset password</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')

@endsection
