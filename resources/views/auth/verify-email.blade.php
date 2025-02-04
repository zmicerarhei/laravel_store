@extends('layouts.main')

@section('title', 'Email confirmation')
@section('content')
    <div class="container_verify">
        <div class="container text-center">
            <div class="alert alert-success">
                Thanks for registering! A link to confirm your registration has been sent to your email.
            </div>
            <div>
                Didn't receive the link?
                <form method="post" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-link ps-0">Send link once more</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')

@endsection
