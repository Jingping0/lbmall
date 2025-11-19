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
            <form action="{{ route("forget.password.post") }}" method="POST" class='ms-auto me-auto mt-auto' style="width: 500px">
              @csrf
                <div class="mb-3">
                <strong>We will send a link to your email, use that link to reset password</strong>
                  <label class="form-label">Email address</label>
                  <input type="email" class="form-control" name="email">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
    
    @endsection
    