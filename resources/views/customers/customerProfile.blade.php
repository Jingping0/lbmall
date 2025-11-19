<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>CSS User Profile Card</title>
	<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/profileUpdate.js') }}" defer></script>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>    

</head>
<body>
    <body>
        @if (session('success'))
        <div class="wrapper">
            <div class="toast toast_success" id="my-container">
                <div class="container">
                    <span class="icon">
                        <i class='bx bx-check-circle'></i>
                    </span>
                    <div id="my-message" class="alert alert-success" role="alert">
                        <span class="message">{{ session('success') }}</span>
                    </div>
                    <span class="close-icon" onclick="closeToast()">
                        <i class='bx bx-x'></i>
                    </span>
                </div>
            </div>
        </div>
    
        <script>
            window.onload = function() {
                var toast = document.getElementById("my-message");
                var toastContainer = document.getElementById("my-container");
    
                setTimeout(function(){
                    toast.style.opacity = "1";
                    toastContainer.style.opacity = "1";
    
                    setTimeout(function() {
                        closeToast();
                    }, 2000);
                }, 50);
            };
    
            const closeToast = () => {
                var toast = document.getElementById("my-message");
                var toastContainer = document.getElementById("my-container");
    
                // Add transition properties to smoothly move to the right
                toast.style.transition = "opacity 0.5s, transform 0.5s";
                toastContainer.style.transition = "opacity 0.5s, transform 0.5s";
    
                toast.style.opacity = "0";
                toastContainer.style.opacity = "0";
                toastContainer.style.transform = "translateX(100%)"; // Move to the right
    
                // Remove the toast after the transition ends
                setTimeout(() => {
                    toast.style.transition = "none";
                    toastContainer.style.transition = "none";
                    toastContainer.style.transform = "none";
                }, 500); // Assuming the transition duration is 0.5s
            };
        </script>
        @endif
    
<div class="wrapper">
    <div class="left">
        @php($userImage =  $customer['userImage'])

        <img class="img"  alt="user" width="100" src="{{ $userImage ? asset('storage/' .$userImage) : asset('img/user.png') }}" id="image_preview_container">
      
        <h4>{{ $customer['name']}}</h4>
        <p>Good Days</p>

         <div class="input-btn">
            <a href="{{ route('profile.home') }}" class="btn">Back</a>
            <a href="{{ url('customerProfileEdit') }}" class="btn">Edit</a>
          
        </div>
    </div>
    <div class="right">
        <div class="info">
            <h3>User Profile</h3>
            <div class="info_data">
                 <div class="data">
                    <h4>👤Username</h4>
                    <p> {{ $customer['username']}}</p>
                    
                    <h4>🟡Name</h4>
                    <p> {{ $customer['name']}}</p>
                    
                    <h4>✉️Email</h4>
                    <p> {{ auth()->user()->email}}</p>

                    <h4>🏠Home Address</h4>
                    <p>23,jalan tingkalang,bandar tinggi</p>
                 </div>

                 <div class="data">
                    <h4>👤Role of User</h4>
                    <p>{{ auth()->user()->role}}</p>
                    
                    <h4>📞Phone</h4>
                    <p> {{ $customer['phone']}}</p>

                    <h4>🗺 Nationality</h4>
                    <p>Malaysia</p>
              </div>
              <div class="data2">
                   
              </div>
            </div>
        </div>

    </div>
</div>

<script>
    window.onload = function() {
        var toast = document.getElementById("liveToast");
        setTimeout(function(){
            toast.style.opacity = "1";
            setTimeout(function() {
                toast.style.opacity = "0";
            }, 2000);
        }, 50);
    };
</script>

</body>
</html>