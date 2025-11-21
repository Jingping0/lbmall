
@extends('layout/checkOutNav')

@section('title', 'Checkout')

@section('header')
<style>
    .card:not(.list-group-item-text) {
        box-shadow: 2.5px 2px var(--bs-gray-400);
        border-right-width: 0px;
        border-radius: 9px;
        backdrop-filter: opacity(1);
    }

    .btn {
        border-radius: 8px;
        border-right-width: 0px;
        box-shadow: 2px 2px 8px 1px var(--bs-gray-500);
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .col-md-5{
        margin-inline-end: 0.75rem;
        display: block;
        margin-inline-start: 0.5rem;
        max-width: 393px;
        width: 100%;
    }   

    .subtotal_text_container{
        padding: 1rem 0;
        border-bottom: 1px solid rgb(var(--colour-neutral-3,223,223,223));
        border-top: 1px solid rgb(var(--colour-neutral-3,223,223,223));
    }

    .box_wrapper{
        padding: 1.5rem 0px 0px 0px;
        color: rgb(var(--colour-neutral-7,17,17,17));
        display: flex;
        margin: 0 auto;
        min-height: inherit;
        border-top: 1px solid rgb(var(--colour-neutral-3,223,223,223));
    }

    .left_container{
        align-self: flex-end;
        flex: 1 1;
    }

    .subtotal_text{
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-size: .875rem;
        font-weight: 700;
        line-height: 1.571;
        margin-bottom: 0px;
    }

    .right_container{
        text-align: right;
        flex: 1 1;
        align-self: flex-end;
    }

    .price_model_wrapper{
        font-size: 2.1rem;
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-weight: 700;
        line-height: 1;
        position: relative;
    }

    .price_currency{
        top: -0.727em;
        unicode-bidi: bidi-override;
        font-size: .5em;
        line-height: 1.3;
        position: relative;
    }

    .cart_container_component{
        padding: 0px 0px 1.5rem 0;
        width: 100%;
        border-bottom: 1px solid rgb(var(--colour-neutral-3,223,223,223));
    }

    .responsive_container{
        display: block;
        justify-content: normal;
        margin: 0 auto;
        width: 100%;
        max-width: 1536px;
    }

    .details_text{
        margin-bottom: 0.5rem;
        min-width: 157px;
        width: auto;
        font-style: normal;
        font-weight: 700;
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-size: .875rem;
        line-height: 1.571;
    }

    .user_details{
        word-wrap: break-word;
        /* white-space: pre-line; */
        width: 100%;
    }

    .user_name{
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .user_address{
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
        white-space: pre-line;
    }

    .status{
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .phone{
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .gmail{
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .details_container_change{
        display: flex;
        justify-content: space-between
    }

    .change_address{
        color: blue;
        font-weight: 400;
        text-decoration: none;
        font-size: 0.9rem
    }

    .change_address:hover{
        text-decoration: underline;
    }

    .cart_product_container_component{
        padding: 1.5rem 0;
        width: 100%;
        padding-bottom: 0!important;
    }

    .product_container{
        display: block;
        justify-content: space-between;
        margin: 0 auto;
        width: 100%;
        max-width: 1536px;
    }

    .product_text{
        font-style: normal;
        font-weight: 700;
        margin-bottom: 0.5rem;
        width: inherit;
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-size: .875rem;
        line-height: 1.571;
    }

    .product_details{
        word-wrap: break-word;
        /* white-space: pre-line; */
        width: 100%;
    }

    .products{
        display: flex;
        line-height: 1.333;
        margin-top: 1rem;
        transition: border-bottom .3s;
        width: inherit;
    }

    .image_wrapper{
        height: 60px;
        margin-bottom: 0;
        margin-top: 0.5rem;
        margin-inline-end: 1rem;
        margin-inline-start: 0;
    }

    .images{
        height: 60px;
        width: 60px;
        background-color: rgb(var(--colour-neutral-2,245,245,245));
        border-style: none;
    }

    .details_wrapper{
        padding-bottom: 0.75rem;
        width: 100%;
    }

    .details_grid{
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        display: flex;
        line-height: 1;
    }

    .product_info{
        flex: 1 1;
        margin-inline-end: 1rem;
        margin-bottom: 0;
        padding: 0;
        position: relative;
    }

    .product_module_info{
        margin-bottom: 0.25rem;
        font-size: .875rem;
        line-height: 1.571;
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-weight: 700;
        order: 2;
        text-transform: uppercase;
    }

    .product_description_wrapper{
        display: block;
        font-weight: 400;
        order: 2;
        text-transform: none;
    }

    .categories{
        display: inline-block;
        margin-inline-end: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .measurement{
        display: inline-block;
        margin-inline-end: 0.25rem;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .price_module_wrapper{
        display: block;
        line-height: 1;
        align-items: center;
        flex-wrap: wrap;
        order: 3;
    }

    .price_wrapper{
        line-height: 1.571;
        font-size: .875rem;
        word-wrap: normal;
        margin-inline-end: 0;
        margin-bottom: 0.25rem;
        color: rgb(var(--colour-text-and-icon-1,17,17,17));
        font-weight: 700;
        position: relative;
    }

    .price_module_currency{
        font-size: 1em;
        line-height: 1;
        top: auto;
        unicode-bidi: bidi-override;
        position: relative;
    }

    .quantity_details{
        display: flex;
        justify-content: space-between;
    }

    .quantity_text{
        display: flex;
        font-weight: 400;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .quantity_number{
        margin-left: 3px;
        font-weight: 700;
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
    }

    .service_box_wrapper{
        color: rgb(var(--colour-neutral-7,17,17,17));
        display: flex;
        margin: 0 auto;
        min-height: inherit;
        margin-bottom: 1.5rem;
    }

    .service_text{
        color: rgb(var(--colour-text-and-icon-2,72,72,72));
        font-size: .875rem;
        line-height: 1.571;
        font-weight: 700;
        margin-bottom: 0;
    }

    .service_price_currency{
        color: #484848;
        font-size: .875rem;
    }

    .service_price_integer{
        color: #484848;
        font-size: .875rem;
    }

    /* toast */

.wrapper {
    position: fixed;
    top: 30px;
    right: 20px;
  }
  
  .toast {
    width: 400px;
    position: relative;
    overflow: hidden;
    list-style: none;
    border-radius: 4px;
    padding: 16px 17px;
    margin-bottom: 10px;
    background: var(--light);
    justify-content: space-between;
    animation: show_toast 0.3s ease forwards;
  }
  
  .toast_success {
    width: 100%;
    height: 70px;
    padding: 20px;
    background: #fff;
    box-shadow: 2px 9px 12px #0002;
    border-radius: 7px;
    text-align: center;
    border-left: 8px solid #04c127;
  }
  
  .toast .container {
    display: flex;
    align-items: center;
  }
  
  .toast .icon i {
    font-size: 1.75rem;
    color: #04c127;
  }
  
  .toast .message {
    font-size: 1.07rem;
    margin-left: 12px;
    flex: 1;
  }
  
  .toast .close-icon i {
    color: #aeb0d7;
    cursor: pointer;
    margin-left: 1rem;
    font-size: 25px;
  }
  
  .toast .close-icon i:hover {
    color: var(--dark);
  }
  
  @keyframes show_toast {
    0% {
        transform: translateX(100%);
    }
    40% {
        transform: translateX(-5%);
    }
    80% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-10px);
    }
  }
  
  /* end toast */

</style>
@endsection

@section('content')
@if (session('success'))
<div class="wrapperT">
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

<div class="container-fluid">

    <div class="mb-4">
        <h1>Your Order</h1>
    </div>

    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('order.placeOrder') }}" method="POST">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-md-7">
                {{-- Delivery Detail --}}
                <div class="card mb-4 mr-1">
                    <div class="card-body">
                        <h5 class="card-title mb-3">1. Delivery Detail</h5>

                        
                        @foreach ($customer->addresses as $address)
                            @if ($address->active_flag === 'Y')
                            <input type="hidden" name="address_id" id="address_id" value="{{ $address->address_id }}">
                            <input type="hidden" name="street" id="street"  value="{{ $address->street }}">
                            <input type="hidden" name="area" id="area"  value="{{ $address->area }}">
                            <input type="hidden" name="postcode" id="postcode"  value="{{ $address->postcode }}">
                            <input type="hidden" name="phone" id="phone"  value="{{ $address->address_userphone }}">

                            <div class="form-group">
                                <label for="street">Street</label>
                                <input type="text" class="form-control" name="street" id="street" placeholder="Enter street" value="{{ $address->street }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="area">Area</label>
                                <input type="text" class="form-control" name="area" id="area" placeholder="Enter area" value="{{ $address->area }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="postcode">Postcode</label>
                                <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Enter postcode" value="{{ $address->postcode }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Enter phone number" value="{{ $address->address_userphone }}" disabled>
                            </div>  
                            @endif
                        @endforeach 
                    </div>
                  </div>
                  


                {{-- Payment --}}
                <div class="card mb-4 ml-1">
                    <div class="card-body">
                        <h5 class="mb-3">2. Payment</h5>
                        <h6 class="mb-2 text-body-secondary">Choose your payment method:</h6>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="paypal" value="paypal" checked>
                            <label class="form-check-label" for="paypal">
                               PayPal
                            </label>
                         </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" value="cashOnDelivery">
                            <label class="form-check-label" for="cashOnDelivery">
                               Cash On Delivery
                            </label>
                         </div>

                         <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="creditCard">
                            <label class="form-check-label" for="creditCard">
                               Credit Card
                            </label>
                         </div>             

                         <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="onlineBanking" value="onlineBanking">
                            <label class="form-check-label" for="onlineBanking">
                                Online Banking
                            </label>
                         </div>

                         <div class="form-check mb-1">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="eWallet" value="eWallet">
                            <label class="form-check-label" for="eWallet">
                               E-Wallet
                            </label>
                         </div>


                    </div>
                </div>

                {{-- Payment Detail --}}
                <div id="cashOnDeliveryDiv" class="payment-details card mb-4 ml-1">
                    <div class="card-body">

                        <h5>Cash On Delivery</h5>

                        <div class="mb-3">
                            <p>You choose <strong>Cash On Delivery</strong>. Once the food arraive to your door, pay your cash to the delivery man!</p>
                        </div>

                    </div>
                </div>

                <div id="creditCardDiv" class="payment-details card mb-4 ml-1" style="display:none;">
                    <div class="card-body">
                        <h5>Credit Card Detail</h5>

                        <div class="form-group my-3">
                            <label for="cardHolder">Card Holder name</label>
                            <input type="text" class="form-control" name="cardHolder" id="cardHolder" placeholder="Enter card holder name" value="{{ old('cardHolder') }}">
                            @error('cardHolder')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cardNumber">Card Number</label>
                            <input type="number" class="form-control" name="cardNumber" id="cardNumber" placeholder="Enter card number" value="{{ old('cardNumber') }}">
                            @error('cardNumber')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="expiryDate">Expiry Date</label>
                            <input type="text" class="form-control" name="expiryDate" id="expiryDate" placeholder="MM/YY" value="{{ old('expiryDate') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="cvv">CVV</label>
                            <input type="number" class="form-control" name="cvv" id="cvv" placeholder="Enter CVV"  value="{{ old('cvv') }}">
                            @error('cvv')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div id="onlineBankingDiv" class="payment-details card mb-4 ml-1" style="display:none;">
                    <div class="card-body">
                        <h5>Online Banking</h5>

                        <div class="form-group my-3">
                            <label for="bankName">Bank Name</label>
                            <select class="form-control" name="bankSelect" id="bankSelect">
                                <option value="">--Select Bank--</option>
                                <option value="Affin Bank">Affin Bank</option>
                                <option value="Alliance Bank">Alliance Bank</option>
                                <option value="AmBank">AmBank</option>
                                <option value="Bank Rakyat">Bank Rakyat</option>
                                <option value="Bank Islam">Bank Islam</option>
                                <option value="BSN">BSN</option>
                                <option value="CIMB">CIMB</option>
                                <option value="Deutsche Bank">Deutsche Bank</option>
                                <option value="HSBC">HSBC</option>
                                <option value="KFH">KFH</option>
                                <option value="Maybank">Maybank</option>
                                <option value="OCBC">OCBC</option>
                                <option value="Public Bank">Public Bank</option>
                                <option value="RHB">RHB</option>
                                <option value="Standard Chartered">Stan
                            </select>
                        </div>
                        <div class="form-group my-3">
                            <label for="bankAccountNumber">Bank Account Number</label>
                            <input type="number" name="bankAccountNumber" class="form-control" id="bankAccountNumber" placeholder="Enter bank account number">
                        </div>
                    </div>
                </div>

                <div id="eWalletDiv" class="payment-details card mb-4 ml-1" style="display:none;">
                    <div class="card-body">
                        <h5>E-Wallet</h5>
                        <h6>Select E-Wallet Platform</h6>

                        <div class="form-group">
                            <div class="form-check my-3">
                                <input class="form-check-input" type="radio" name="eWalletPlatform" id="grabPay" value="GrabPay" checked>
                                <label class="form-check-label" for="grabPay">
                                    GrabPay
                                </label>
                            </div>
                        
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="eWalletPlatform" id="boost" value="Boost">
                                <label class="form-check-label" for="boost">
                                    Boost
                                </label>
                            </div>
                        
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="eWalletPlatform" id="tng" value="Touch 'n Go eWallet">
                                <label class="form-check-label" for="tng">
                                    Touch 'n Go eWallet
                                </label>
                            </div>
                        
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="eWalletPlatform" id="ipay" value="iPay88">
                                <label class="form-check-label" for="ipay">
                                    iPay88
                                </label>
                            </div>
                        </div>
                    </div>
                </div>



                <button type="submit" class="btn btn-primary">Place Order</button>
                <a class="btn btn-secondary" href="{{ route('cart.index') }}">Back</a>

            </div>

            <div class="col-md-5">
                {{-- Order Detail --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">3. Order Detail</h5>
                        <div class="block" style="display: block;">
                            <div class="cart_container_component">
                                <div class="responsive_container">
                                    <div class="details_container_change">
                                        <h6 class="details_text">Your details</h6>
                                        <a href="{{ route('address.getCustomerAddress') }}" class="change_address">change</a>
                                    </div>
                                    <div class="user_details">
                                        @foreach ($customer->addresses as $address)
                                            @if ($address->active_flag == 'Y')
                                                <p class="user_name">{{ auth()->user()->username }}</p>
                                                <p class="user_address">{{ $address->street }}, {{ $address->area  }}, {{ $address->postcode }}</p>
                                                <p class="status">Selangor</p>
                                                <p class="phone">{{ $address->address_userphone }}</p>
                                                <p class="gmail">{{ auth()->user()->email }}</p>
                                            @endif                                       
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="cart_product_container_component">
                                <div class="product_container">
                                    <h6 class="product_text">Products</h6>
                                    @foreach ($customer->cart->cartItems as $item)
                                        <div class="product_details">
                                            <div class="products">
                                                <div class="image_wrapper">
                                                    @php($product_image =  $item->productItem['product_image'])
                                                    <img class="images" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                                </div>

                                                <div class="details_wrapper">
                                                    <div class="details_grid">
                                                        <div class="product_info">
                                                            <div class="product_module_info">
                                                                <span class="C">{{ $item->productItem->product_name }}</span>
                                                                <span class="product_description_wrapper">
                                                                    <span class="product_description">
                                                                        <span class="categories">{{ $item->productItem->category->category_name }}</span>
                                                                        <span class="measurement">{{ $item->productItem->product_measurement }} cm</span>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="price_container">
                                                            <div class="price_module_wrapper">
                                                                <span class="price_wrapper">
                                                                    <span class="price">
                                                                        <span class="price_module_currency">RM</span>
                                                                        <span class="price_module_integer">{{ $item->productItem->product_price * ( $item->quantity) }}</span>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="quantity_details">
                                                        <p class="quantity_text">Qty: 
                                                            <span class="quantity_number">{{ $item->quantity}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                            <div class="subtotal_text_container">

                                                <div class="service_box_wrapper">
                                                    <div class="left_container">
                                                        <h1 class="service_text">Service Tax (6%)</h1>
                                                    </div>
                                                    <div class="right_container">
                                                        <span class="price_model_wrapper">
                                                            <span class="service_price_currency">RM</span>
                                                            <span class="service_price_integer">{{number_format($customer->cart->subtotal * 0.06 , 2)  }}</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                
                                                <div class="box_wrapper">
                                                    <div class="left_container">
                                                        <h1 class="subtotal_text">Total Price</h1>
                                                    </div>
                                                    <div class="right_container">
                                                        <span class="price_model_wrapper">
                                                            <span class="price_currency">RM</span>
                                                            <span class="price_integer">{{ str_replace(',', '', number_format($customer->cart->subtotal + ($customer->cart->subtotal * 0.06), 2)) }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>

            </div>
            <div id="paypalDiv" class="payment-details card mb-4 ml-1" style="display:none;">
               
                <div class="card-body">
                    <h5>PayPal</h5>
                    <img src="{{ asset('img/paypal.png') }}" alt="PayPal">

                    <form action="{{ route('paypal') }}" method="POST">
                        @csrf
                        <input type="hidden" name="price" value="{{ str_replace(',', '', number_format($customer->cart->subtotal + ($customer->cart->subtotal * 0.06), 2)) }}">
                        <input type="hidden" name="product_name" value="AAA">
                        <input type="hidden" name="Quantity" value="1">
                        <button class="btn btn-primary" type="submit">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    

</div>



    
<script>
    // Get all radio buttons with name="paymentMethod"
    const paymentMethodRadios = document.getElementsByName('paymentMethod');

    // Add event listener to each radio button
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            handlePaymentMethodChange(radio.value);
        });
    });

    // Function to handle change in payment method
    function handlePaymentMethodChange(paymentMethod) {
        // Hide all payment-details divs
        const paymentDetailsDivs = document.querySelectorAll('.payment-details');
        paymentDetailsDivs.forEach(div => {
            div.style.display = 'none';
        });

        // Show the selected payment-details div
        const selectedPaymentDetailsDiv = document.querySelector(`#${paymentMethod.toLowerCase()}Div`);
        selectedPaymentDetailsDiv.style.display = 'block';
    }
</script>



@endsection