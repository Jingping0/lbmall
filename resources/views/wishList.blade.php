<!DOCTYPE html>
<html>
 
    @section('title', 'WishList')

    @section('header')
    
    @endsection
   
    @include('layout.wishList_layout')
    <link rel="stylesheet" href="{{ asset('css/wishList.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

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
            if (!toast || !toastContainer) return;

            // show
            toast.style.opacity = "1";
            toastContainer.style.opacity = "1";
            toastContainer.style.pointerEvents = "auto";

            // auto close after 2s
            setTimeout(function() {
                closeToast();
            }, 2000);
        };

        const closeToast = () => {
            var toast = document.getElementById("my-message");
            var toastContainer = document.getElementById("my-container");
            if (!toast || !toastContainer) return;

            toast.style.transition = "opacity 0.5s, transform 0.5s";
            toastContainer.style.transition = "opacity 0.5s, transform 0.5s";

            // hide visually and disable pointer events immediately
            toast.style.opacity = "0";
            toastContainer.style.opacity = "0";
            toastContainer.style.transform = "translateX(100%)";
            toastContainer.style.pointerEvents = "none";

            // remove from DOM after transition so it won't block anything
            setTimeout(() => {
                if (toastContainer.parentNode) toastContainer.parentNode.removeChild(toastContainer);
            }, 500);
        };
    </script>
    @endif


    <script>
document.addEventListener('DOMContentLoaded', function () {
    const btn_inner_plus = document.querySelector(".btn_inner_plus");
    const btn_inner_minus = document.querySelector(".btn_inner_minus");
    const stepper_input = document.querySelector(".stepper_input");

    // 只有全部元素存在时才绑定事件，避免抛错阻断其它脚本
    if (btn_inner_plus && btn_inner_minus && stepper_input) {
        let a = parseInt(stepper_input.value) || 1;

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
    }
});
</script>
 
 <body>
    <div class="root">
        <div class="main">
            <div class="PageContainer_grid">
                <div class="PageContainer_main">
                    <div class="bottomDivider">
                        <div class="app">
                            <div>
                                <h1 class="favourites_h1">Favourites</h1>
                                <section class="Listpage_content">
                                    <section class="Listpage_article">
                                        <div>
                                                <div class="list_page_item">
                                                    <div class="list_product">
                                                        <?php
                                                        $totalPrice = 0;
                                                        $count =0 ;
                                                        ?>
                                                        
                                                        @foreach ($wishLists as $wishList)
                                                        @foreach ($wishList->wishListItems as $wishItem)
                                                       
                                                        <section class="ListProduct_grid">
                                                            <a class="image_a" href="">
                                                                <span class="image_wrapper">
                                                                    @php($product_image =  $wishItem['product_image'])
                                                                    <img class="product_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                                                </span>
                                                            </a>
                                                            <section class="ListProduct_details">
                                                                <a href="" class="product_detail_a">
                                                                    <div class="product_details_wrapper">
                                                                        <div class="product_details">
                                                                            <div class="product_detail">
                                                                                <!-- Check if productItem exists before accessing its properties -->
                                                                                @if ($wishItem->productItem)
                                                                                    <span class="product_item_name">{{ $wishItem->product_name }}</span>
                                                                                    <span class="product_item_detail">
                                                                                        <p class="product_detail_text">{{ $wishItem->category->category_name }}, {{ $wishItem->product_measurement }} cm</p>
                                                                                    </span>
                                                                                @else
                                                                                    <span class="product_item_name">Product Not Available</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="product_price">
                         
                                                                            <span class="price">RM{{ $wishItem->product_price }}</span>
                                                                            <?php
                                                                            $count++;
                                                                            $totalPrice += $wishItem->product_price;
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                <div class="ListProduct_addToCart">
                                                                    <div class="ListProduct_interactionContainer">
                                                                        <form id="addToCartForm" action="{{ route('cart.addWishToCartItem', ['product_item' => $wishItem->product_item_id]) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="addToCart_btn">
                                                                                <span class="addToCart_span">
                                                                                    <i class="addToCart_icon bx bx-cart-add"></i>
                                                                                    <input type="hidden" name="productId" >
                                                                                </span>
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('removeWishListItem', ['productItem' => $wishItem->product_item_id]) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="remove_btn" type="submit">
                                                                                <span class="prefix_btn_inner">
                                                                                    <span class="btn_label">Remove</span>
                                                                                </span>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </section>
                                                        @endforeach
                                                        @endforeach
                                                    </div>
                                                </div>            
                                        </div>
                                        
                                    </section>
                                    
                                    <section class="Listpage_summary">
                                        <section class="summary_summary">
                                            <h1 class="summary_title">Summary</h1>
                                            <span class="summary_wrapper">Types
                                                <span class="price_wrapper">
                                                    <span class="">
                                                        <span class="price_currency"></span>
                                                        <span class="price_integer">{{ $count }} Products</span>
                                                    </span>
                                                </span>
                                            </span>
                                            <div class="divider"></div>
                                            <span class="total_price_info">
                                                <strong class="price_details_text">Total incl. VAT</strong>
                                                <span class="price_model_total_price">
                                                    <span class="price_module_currency">RM</span>
                                                    <span class="price_module_integer">{{ $totalPrice }}</span>
                                                </span>
                                            </span>
                                            <form action="{{ route('addAllToCart') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="addAllItemToCart_btn">
                                                    <span class="addCart_btn">
                                                        <i class="addToCart_icon bx bx-cart-add"></i>
                                                        <span class="button_text">Add all items to cart</span>
                                                    </span>
                                                </button>
                                            </form>
                                        </section>
                                    </section>
                                    
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
<br><br><br><br><br><br><br><br><br><br>
<!-------FOOTER--------->
@include('layout.footer')



</html>
