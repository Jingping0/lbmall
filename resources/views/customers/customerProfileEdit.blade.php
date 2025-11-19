<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/log_reg.css') }}">
        <script src="{{ asset('js/profileUpdate.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <title>Edit User Profile</title>
    </head>
<body>

@section('content')



    {{-- <%
    Customer customer = (Customer) session.getAttribute("customer");

    if (customer != null) {
%> --}}
        <div class="container" style="">
            <form method="POST" enctype="multipart/form-data" id="profile_setup_frm" action="{{ route('customerProfileEdit.post') }}" >
                @csrf
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Edit User Profile</p>
                @if ($errors->any())
                <div class="alert alert-danger"style="color: red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="input-groups">
                <h3 class="str">Username: </h3>
                <input type="text" name="username" value="{{ $customer ->username }}" class="form-control" placeholder="Username">
            </div>
            <div class="input-groups">
                <h3 class="str">Name: </h3>
                <input type="text" name="name" value="{{ $customer ->name }}" class="form-control" placeholder="Name">
            </div>
            <div class="input-groups">
                <h3 class="str">Email: </h3>
                <input type="email" name="email" value="{{ $customer ->email }}" class="form-control" placeholder="Email">
            </div>
            <div class="input-groups">
                <h3 class="str">Phone Number: </h3>
                <input type="text" name="phone" value="{{ $customer ->phone }}" class="form-control" placeholder="Phone">
            </div>
            <div class="">
                <h3 class="str">User Profile: </h3>
                <input type="file" name="userImage" id="userImage"  class="form-control">
            </div>
            <br>
            <div class="input-group">
                <button type="submit" class="btn">Edit</a>
            </div>
            <div class="input-group">
                <a  class="btn" href="{{ route('customerProfile') }}">Back</a>
            </div>

            
                       
               
    </form>


</body>
</html>