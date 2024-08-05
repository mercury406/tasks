@extends('layout')

@section('content')
    <div class="col-4 mx-auto mt-5 py-5">
        <form action="{{ route('register') }}" class="mt-5" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name">
            </div>

            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password</label>
                <input type="password" class="form-control" id="password_confirmation" placeholder="Password confirmation" name="password_confirmation">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-info" id="btnLogin" value="Register">
                <a href="{{route('login')}}" class="mx-3">Login?</a>
            </div>
        </form>
    </div>

@endsection
