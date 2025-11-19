<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Change Password</title>
       <!-- Scripts -->
	<link rel="stylesheet" href="/css/profile.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/profileUpdate.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>    
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>
<body>

<div class="wrapper">
    
    <div class="left">
        @php($userImage = auth()->user()->userImage)
        <img class="img"  alt="user" width="100" src="{{ $userImage ? asset('storage/' . $userImage) : asset('storage/userImage/userProfile.png') }}" id="image_preview_container">

        <h4>{{ auth()->user()->name}}</h4>
         <p>Good Days</p>

         <div class="input-btn">    
                <a href="{{ route('profile.home') }}" class="btn">Back</a>
        </div>
    </div>
    <div class="right">
        
    @if (session('message'))
        <h5 class="alert alert-success mb-2">{{ session('message') }}</h5>
    @endif

    @if ($errors->any())
        <ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <li class="text-danger">{{ $error }}</li>
    @endforeach
        </ul>
    @endif    
        <h2>Change Customer Passowrd</h2>
            <form method="POST" action="{{ route('changeCustPasswordPost') }}">
                @csrf
                <div class="container">
                    <div class="input">
                        <h6>Current Password</h6>
                        <input type="password" class="box" name="current_password" id="current_password">
                    </div>
    
                    <div class="input">
                        <h6>New Password</h6>
                        <input type="password" class="box" name="password" id="password">
                    </div>
                    <div class="input">
                        <h6>Comfirm Password</h6>
                        <input type="password" class="box" name="password_confirmation" id="password_confirmation">
                    </div>
                    
                    <div class="input-btn">
                        <button type="submit" class="btns">Reset Password</button>
                        <a class="btnss" href="{{ route('logout') }}">Logout</a>
                    </div>
                   
                </div>
            </form>

        </div>

    </div>
</div>

</body>
</html>




