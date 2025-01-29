@extends('layouts.main')

@section('title', 'Log in')
@section('content')

    <div class="container_100vh d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h1 class="h2 text-center">Вход</h1>
                    <form action="{{ route('authenticate') }}" method="POST" novalidate>
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Емейл</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" class="form-control" id="password">
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
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary w-100">Log in</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')

@endsection
