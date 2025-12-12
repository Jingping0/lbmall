<!DOCTYPE html>
<html>

    <!-- header -->
        @include('layout.subNav')
    <!-- EndHeader -->


<body>
    <div class="grid_container">
        <div class="grid_title">
            <h1 class="haj">Hey, {{ $customer->name }}</h1>
            <span class="log_text">Need to change account?
                <a class="log_button" href="{{ route('logout') }}">Log out</a>         
            </span>
        </div>
        <div class="container_left">
            <div class="img_container">
                <img class="spaka_image" src="{{ asset('img/profile_home.avif') }}" >
            </div>
            <div class="card_container">
                <div class="card_content">
                    <h1>Welcome home to your LB's profile</h1>
                    Here is your own cosy corner of LB where you can update your info.
                </div>
            </div>
        </div>     

        <div class="container_right">
            <h2>Your profile</h2>

            <ul>
                <li class="list">
                    <a href="{{ route('customerProfile') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fas fa-solid fa-user"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">{{ $customer->name }}</span>
                                <span class="list_content_sec">View and edit your profile details</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>

                <li class="list">
                    <a href="{{ route('address.getCustomerAddress') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fas  fa-map-marker-alt"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">Customer Address</span>
                                <span class="list_content_sec">View and edit your address details</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>

                <li class="list">
                    <a href="{{ route('changeCustPassword') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fa fa-lock"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">Change Password</span>
                                <span class="list_content_sec">Requires current password</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>

                <li class="list">
                    <a href="{{ route('pusher.index') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fas fa-solid fa-comment"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">Live Chat</span>
                                <span class="list_content_sec">Immediately customer support</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>

                <li class="list">
                    <a href="{{ route('showFAQ') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fas fa-question-circle"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">FAQ</span>
                                <span class="list_content_sec">Reply Frequently question from customerr</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>

                <li class="list" style="border-bottom: 1px solid rgb(var(--colour-elevation-1-border,223,223,223));">
                    <a href="{{ route('deleteAccount') }}" class="btn_list">
                        <span class="span_list">
                            <div class="icon"><i class="fa fa-trash"></i></div>
                            <span class="list_item">
                                <span class="list_content_main">Delete Account</span>
                                <span class="list_content_sec">Leave whenever you want</span>
                            </span>
                            <span>
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        
    </div>
    

<!-------FOOTER--------->

@include('layout.footer')


</body>
</html>