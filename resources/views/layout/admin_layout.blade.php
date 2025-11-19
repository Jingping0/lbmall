<!DOCTYPE html>
<html>

<head>
    <title>@yield('title', 'Default Title')</title>

    @include('components.common-head')
    @yield('css')
    <style>
        *{
            margin: 0;
            padding: 0;
        }

        html{
            height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: rgb(246, 249, 255);
            user-select: none;
            height: 100%;
        }

        .side{
            background-color: black;
        }

        .sidebar .nav-item{
            padding: 0 0.85rem;
            margin-bottom: 0.3rem;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            padding: 12px 30px;
        }

        .sidebar .nav-item .nav-link:hover , .active{
            background-color: #007bff;
            color:#fff;
            border-radius: 3px;
        }

        .active{
            color: white;
        }

        .navbar {
            display: flex;
            justify-content: end;
            background-color: #fff;
            align-items: center;
            padding-left: 20px;
            padding-right: 20px;
            height: 70px;
        }

        .navbar .navbar-nav{
            display: flex;
            flex-direction: row;
        }

        .navbar .navbar-nav li{
            display: flex;
            align-items: center;
            padding: 0 0.9rem;
        }
        

        .content {
            padding-left: 40px;
            padding-right: 40px;
        }

        .error {
            color: red;
        }

        .form-error {
            border: 2px solid #e74c3c;
        }

        .bs-sidebar .nav>.active>ul {
            display: block;
            margin-bottom: 8px;
        }

        footer {
            margin-top: 40px;
            border-top: 1px solid #95A5A6;
            padding: 30px;
            text-align: center;
        }

        .custom-card-1 {
        border-left: 5px solid #ff0000;
    }

    .custom-card-2 {
        border-left: 5px solid #1cc88a;
    }

    .custom-card-3 {
        border-left: 5px solid #0000ff;
    }

    .status .card-body {
        align-items: center;
    }

    .title{
        display: flex;
        align-items: center;
    }
    
    .container-top-selling {
        background-color: #fff;
        height: 20rem;
    }

    .content-title{
            font-size: 22px;
            font-weight: bold;
        }
        
    .main-content{
        display: flex;
        flex-direction: column;
        padding: 1rem;
        height: 100%;
        min-height: calc(100vh - 100px);
        gap: 20px;
    }


        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap');
    </style>
</head>

<body>
    <div class="row g-0">
        <div class="col-sm-2 side overflow-auto" style="height: 100vh; position: fixed;">
            @include('layout.admin_sidebar')
        </div>

        <!--    For margin use     -->
        <div class="col-sm-2"></div>

        <div class="col-10 rightside">
            <div class="col-12 shadow navbar">
                <ul class="navbar-nav">
                    {{-- <li class="nav-item">
                        <i class="fa-regular fa-bell"></i>
                    </li> --}}
                    <li class="nav-item">
                        <i class="fa-regular fa-envelope"></i>
                    </li>
                </ul>
                <div class="dropdown">
                    <div class="" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span class="me-2">Chiang Jing Shiun</span>
                        <img class="img-profile rounded-circle" style="max-width: 50px; max-height: 50px" src="{{ asset('img//adminProfile.png') }}">
                    </div>
                    
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="{{ route('staffProfile') }}">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>
                                Setting
                            </a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <form action="{{ route('logout') }}" >
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

</body>

</html>
