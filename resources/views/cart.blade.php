<!DOCTYPE html>
<html>
 
    @section('title', 'Cart')

    @section('header')
    
    @endsection
    @include('layout.subNav')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

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


<body>
    <div class="root">
        <div class="main">
            <div class="grid_content">
                <div class="content">
                    <div class="cartpage_wrapper">
                        <div class="cart_page">
                            <h1 class="cart_h1">Your shopping cart</h1>
                            <div class="cartpage_content">
                                <div class="cartpage_carlist_wrapper">
                                    <p class="text_of_item">items in total</p>
                                    <div class="cartList">
                                        @if ($cart && $cart->cartItems->isNotEmpty()) 
                                        @foreach($cart->cartItems as $cartItem)
                                        <div class="cartItem_wrapper">
                                            <div class="cartItem">
                                                <div class="cartItem_detailsWrapper">
                                                    <div class="cartItem_image">
                                                        @php($product_image =  $cartItem->productItem['product_image'])
                                                        <img class="item_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                                    </div>
                                                    <div class="cartItem_info">
                                                        <div class="item_info_wrapper">
                                                            <div class="item_info">
                                                                <div class="item">
                                                                    <span class="item_name">{{ $cartItem->productItem->product_name }}</span>
                                                                    <span class="item_details">
                                                                        <div class="detail">Table, White</div>
                                                                        <div class="measurement">{{ $cartItem->productItem->product_measurement }}cm</div>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="price">
                                                                <div class="price_container">
                                                                    <span class="price_pricewrapper">
                                                                        <span class="left_price_currency">RM</span>
                                                                        <span>{{ number_format($cartItem->productItem->product_price, 2) }}</span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="cartItem_itemOption">
                                                            <div class="quantity_wrapper">
                                                                <input class="stepper_input" type="text" inputmode="numeric" min="1" max="10" value="{{ $cartItem['quantity'] }}">
                                                                <a class="quantity_option_btn_increase" type="button" href="{{ route('updateQuantity', ['requestedProductItemId' => $cartItem->productItem->product_item_id, 'action' => 'increase']) }}"> 
                                                                    <span class="btn_inner_plus">
                                                                        <i class="quantityOption fa fa-plus"></i>
                                                                    </span>
                                                                </a>
                                                                <a class="quantity_option_btn_decrease" type="button" href="{{ route('updateQuantity', ['requestedProductItemId' => $cartItem->productItem->product_item_id, 'action' => 'decrease']) }}">
                                                                    <span class="btn_inner_minus">
                                                                        <i class="quantityOption fa fa-minus"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <a class="remove_btn" type="button" href="{{ route('removeCartItem', ['requestedProductItemId' => $cartItem->product_item_id]) }}"> 
                                                                <span class="prefix_btn_inner">
                                                                    <span class="btn_label">Remove</span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                            <div>
                                                <h4>You don't have any items in your cart.</h4>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <section class="cartpage_summary">
                                    <div class="summary">
                                        <h3 class="summary_h3">Order summary</h3>
                                        <div class="summary_receipt">
                                            <div class="summary_sub_row">
                                                <span class="text_of_total_product">Subtotal</span>
                                                <span class="price_module_wrapper">
                                                    <span class="price_currency">RM</span>
                                                    <span class="price_integer">{{ $cart->subtotal }}</span>
                                                </span>
                                            </div>
                                            <div class="summary_sub_row">
                                                <span class="text_of_total_product">Service Tax (6%)</span>
                                                <span class="price_module_wrapper">
                                                    <span class="price_currency">RM</span>
                                                    <span class="price_integer">{{ number_format($cart->subtotal * 0.06, 2) }}</span>
                                                </span>
                                            </div>
                                            <div class="summary_row">
                                                <span class="text_of_subtotal">Total (excl. Delivery & Assembly fees)</span>
                                                <span class="summary_total_price">
                                                    <span class="summary_price_currency">RM</span>
                                                    <span class="summary_price_integer">{{ number_format($cart->subtotal + ($cart->subtotal * 0.06), 2) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="privacy_policy">By clicking "Checkout" you're agreeing to our 
                                            <a class="privacy_policy_a" href="">Privacy Policy</a>
                                        </span>
                                        <span class="summary_button_wrapper">
                                            <a href="{{ route('cart.toCheckout') }}" class="Checkout_button">
                                                <span class="Checkout_btn_inner">
                                                    <span class="Checkout_label">Checkout</span>
                                                </span>    
                                            </a>
                                        </span>
                                    </div>
                                </section>
                            </div>
                    
                            
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const btn_inner_plus = document.querySelector(".btn_inner_plus");
        const btn_inner_minus = document.querySelector(".btn_inner_minus");
        const stepper_input = document.querySelector(".stepper_input");
    
        let a = 1;
    
        btn_inner_plus.addEventListener("click", () => {
            a++;
            if (a <= 999) {
                stepper_input.value = a;
            } else {
                a = 999;
                stepper_input.value = a;
            }
            console.log(a);
        });
    
        btn_inner_minus.addEventListener("click", () => {
            if (a > 1) {
                a--;
                stepper_input.value = a;
            }
        });
    
        stepper_input.addEventListener("input", () => {
            let inputValue = parseInt(stepper_input.value);
            if (isNaN(inputValue) || inputValue < 1) {
                inputValue = 1;
            } else if (inputValue > 999) {
                inputValue = 999;
            }
            a = inputValue;
            stepper_input.value = a;
        });
    </script>
 
</body>
<br><br><br><br><br><br><br><br><br><br>
<!-------FOOTER--------->
@include('layout.footer')



</html>
