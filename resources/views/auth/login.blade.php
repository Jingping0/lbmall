<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="image/small_logo.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{ asset('css/log_reg.css') }}">
        <title>Yeekia | Login</title>
    </head>
    <body>
        <div class="container">
            <div class="mt-5">
                @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger "style="color: red;">{{ $error }}</div>
                    @endforeach
                </div>
                @endif  
        
                <div>
                    @if(session()->has('error'))
                    <div class="alert alert-danger"style="color: red;">{{ session('error') }}</div>
                    @endif
        
                    @if(session()->has('success'))
                    <div class="alert alert-success"style="color: green;">{{ session('success') }}</div>
                    @endif
                </div>
            </div>
            <form action="{{ route("login.post") }}" method="POST" class="login-email">
                @csrf 
    
                <p class="login-text">Login</p>
                <div class="input-group">
                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">
                </div>
                <div class="input-group">
                    <input type="password" placeholder="Password" name="password" value="{{ old('password') }}">
                </div>
                <div class="input-group">
                    <button name="submit" class="btn">Login</button>
                </div>
                <p class="login-register-text">Don't have an account? <a href="registration">Register Here</a>.</p>
                <p class="login-register-text">Forgot Password? <a href="forget-password">Click Here</a>.</p>
            </form>
        </div>
    </body>
</html>