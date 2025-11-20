<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{ asset('css/cus_addAddress.css') }}">

</head>
<body>

<div class="container">

    <form action="{{ route('address.store') }}" method="POST">
        @csrf

        <h3 class="title">address</h3>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="row">

            <div class="col">

                <div class="inputBox">
                    <span>full name :</span>
                    <input type="text" placeholder="john deo" name="username">
                </div>
                <div class="inputBox">
                    <span>Street :</span>
                    <input type="text" placeholder="23, Jalan Mamak" name="street">
                </div>
                <div class="inputBox">
                    <span>Post Code :</span>
                    <input type="text" placeholder="41200" name="postcode">
                </div>
                <!-- <div class="inputBox">
                    <span>city :</span>
                    <input type="text" placeholder="mumbai">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>state :</span>
                        <input type="text" placeholder="india">
                    </div>
                    <div class="inputBox">
                        <span>zip code :</span>
                        <input type="text" placeholder="123 456">
                    </div>
                </div> -->

            </div>

            <div class="col">

            <div class="inputBox">
                    <span>Phone Number :</span>
                    <input type="tel" placeholder="011-11222333" name="address_userphone" >
                </div>

                <div class="inputBox">    
                    <span>Area :</span>   
                    <input type="text" placeholder="Kuala Lumpur" name="area">
                </div>

            </div>
    
        </div>
            <a href="{{ route('address.cusAddress') }}" class="submit-btn btns" type="submit">Back</a>
            <input type="submit" value="Add" class="submit-btn">
        </form>
        
        
    
    
</div>    

</body>
</html>