@section('title','Registration')

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/log_reg.css">
        
        <title>PestaPanda | Register</title>
    </head>
    <body>
        <div class="container">

            <form action="{{ route("registration.post") }}" method="POST" class="login-email">
                @csrf
                <div class="error">                                        
                    @if($errors->any())
                    <div class="col-12">
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif
            
                    @if(session()->has('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
            
                    @if(session()->has('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                </div>

                <p class="login-text">Register</p>
                <div class="input-group">
                    <input type="text" placeholder="Username" name="username" value="{{ old('username') }}">
                </div>

                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="{{ old('password') }}">
                </div>
                <div class="input-group">
                    <input type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                </div>
 
                <div class="input-group">
                    <input type="email" placeholder=" Email" name="email" value="{{ old('email') }}">
                </div>
 
                <div class="input-group">
                    <button type="submi" name="submit" class="btn">Register</button>
                </div>
                <p class="login-register-text">Have an account? <a href="login">Login Here</a>.</p>
            </form>
        </div>

    </body>
</html>



