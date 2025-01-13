@extends('layouts.main')

@section('title', 'Sign Up')
@section('content')

    <div class="container_100vh d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <h1 class="h2 text-center">Регистрация</h1>
            <form action="{{ route('register') }}" method="POST" novalidate class="w-50 mx-auto">
                @csrf
                <div class="form-group mb-3">
                    <label for="name">Имя</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Емейл</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirmation">Подтвердите пароль</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="submit" class="btn btn-primary w-100">Sign up</button>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}">Already have an account?</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom_js')

@endsection
