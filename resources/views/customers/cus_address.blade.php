<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="{{ asset('css/cus_address.css') }}">
    {{-- ICON --}}
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <title>JSP Page</title>
    </head>
<body>
    
    <div class="container-root">
        <th><p class="title" style="font-size: 2rem; font-weight: 800;">My Address</p></th>
        
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

        @foreach ($cusAddresses as $address)
        
        <div class="containers">
            <div class="pub_info">
                <h3 class="address_name">{{ $address->username }}</h3>
                <p>| (+60) {{ ($address->address_userphone) }}</p>
                <a href="{{ route('address.edit', $address->address_id) }}">Edit</a>
                <form action="{{ route('address.destroy', $address->address_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="remove_btn"><i class='bx bx-trash fa-2x'></i></button>
                </form>
            </div>
            <p>{{ $address->street }}, {{ $address->area }}, {{ $address->postcode }}</p>
            @if ($address->active_flag == 'Y')
                <button type="submit" class="btns" disabled>Current Used</button>
            @else
                <form action="{{ route('address.setDefault', ['address' => $address->address_id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button id="my-button" type="submit" class="btns">Set As Default</button>
                </form>
            @endif
        </div>
        @endforeach


            <table>
                <div class="input-group">
                    <tr>
                        <td>
                            <button type="button" onclick="location.href='{{route('profile.home') }}';" name="submit" class="btn">Back</button>
                        </td>
                        <td>
                            <button onclick="location.href='{{ route('address.create') }}';" class="btn">Add</button>
                        </td>
                    </tr>
                </div>
            </table>
    </div>

        <!-- Customer  not found
        <p><a href="index.html">Back to home page</a></p> -->

        {{-- <script>
            const button = document.getElementById("my-button");
            const message = document.getElementById("my-message");

            button.addEventListener("click", () => {
            message.classList.add("show");
            });
        </script> --}}


</body>
</html>