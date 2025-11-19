@extends('auth/layout')
@section('title','Login')
@section('content')
    <div class="container">
        <div class="mt-5">
            @if($errors->any())
            <div class="col-12">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            </div>
            @endif
    
            <div>
                @if(session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
    
                @if(session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
        <strong>We will send a link to your email, use that link to reset password</strong>
        <form action="{{ route("reset.password.post") }}" method="POST" class='ms-auto me-auto mt-auto' style="width: 500px">
          @csrf
          <input type="text" name="token" hidden value="{{ $token }}">
            <div class="mb-3">
              <label class="form-label">Email address</label>
              <input type="email" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Email new password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label class="form-label">Confrim Password</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>

@endsection
