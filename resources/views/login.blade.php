@extends('layout')

@section('content')
    <div class="col-4 mx-auto mt-5 py-5">
        <form action="{{ route('login') }}" class="mt-5" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" name="email">
            </div>

            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="password" name="password">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-info" id="btnLogin" value="Login">
                <a href="{{route('register')}}" class="mx-3">Register?</a>
            </div>
        </form>
    </div>

@endsection
