<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
        <link rel="stylesheet" href="{{ asset('css/product.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <script src="{{ asset('js/filter.js') }}" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- fontawesome -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

	    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <!-- End fontawesome -->
       <!-- header -->
    </head>
    @include('layout.subNav')
    <style>        
        #success-message {
            display: none;
            font-size: 18px;
            color: green;
            margin-top: 10px;
        }
        
    </style>
    
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
        <div class="content">
            <div class="wrapper">
                <h1 class="text-title">YEEKIA Products</h1>
                <!-- filter Items -->
               <nav>
                    <ul class="items">
                        <li>
                            <a href="{{ route('product_items.index') }}" class="{{ !request('category') ? 'active' : '' }}">All</a>
                        </li>

                        @foreach($categories as $category)
                            @php $product_items = $category->productItems()->get(); @endphp

                            <li>
                                @if(count($product_items) > 0)
                                    <a href="{{ route('product_items.index', ['category' => $category->category_id]) }}"
                                    class="{{ request('category') == $category->category_id ? 'active fw-bold' : '' }}">
                                    {{ $category->category_name }}
                                    </a>
                                @else
                                    <a class="disabled">{{ $category->category_name }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="gallery">
                    @forelse ($productItems as $productItem)
                        @if ($productItem->available)
                            <div class="image" style="display: flex;flex-direction:column;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);  ">
                                <a href="{{ route('product.details', ['product_item_id' => $productItem->product_item_id]) }}" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $productItem->id }}">
                                    
                                    <button type="submit" name="" style="background: none; border: none;">
                                        @php($product_image =  $productItem['product_image'])
                                        <span><img src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" style="width: 270px; height:300px; margin-left:33px;" alt=""></span>
                                        <div class="product_details" style="height: fit-content; text-align: justify;">
                                            <a href="" class="product_details_a">
                                                <div class="product_details_wrapper">
                                                    <div class="product_item_details">
                                                        <h3 class="details">
                                                            <span class="item_name_wrapper">
                                                                <span class="item_name">{{ $productItem->product_name }}</span>
                                                            </span>
                                                            <span class="item_details">{{ $productItem->category->category_name }}, {{ $productItem->product_measurement }} cm</span>
                                                        </h3>
                                                    </div>
                                                    <div class="">
                                                        <div class="item_price_grid">
                                                            <span class="item_price_wrapper">
                                                                <span class="item_price_currency">RM</span>
                                                                <span class="item_price_integer">{{ $productItem->product_price }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </button>
                                </a>
                                <div>
                                    {{-- <div>
                                        <!-- Add to Cart Form -->
                                        <form id="addToCartForm" action="{{ route('cart.addProductItem', ['product_item' => $productItem->product_item_id]) }}" method="POST">
                                            @csrf
                                            <!-- Add any additional form fields as needed -->
                                            <input type="hidden" name="productId" value="{{ $productItem->id }}">
                                            <button type="submit" class="btn" style="padding: 0px; cursor: pointer;">
                                                <i class="fas fa-shopping-cart cart-icon3"></i>
                                            </button>
                                        </form>
                                    </div> --}}
                                
                                    <div class="button_container">
                                        <div class="function_button_container">
                                            <form id="addToCartForm" action="{{ route('cart.addProductItem', ['product_item' => $productItem->product_item_id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="addToCart_btn">
                                                    <span class="btn_inneer">
                                                        <i class="addToCart_icon bx bx-cart-add"></i>
                                                        <input type="hidden" name="productId" value="{{ $productItem->id }}">
                                                    </span>
                                                </button>
                                            </form>
                                           
                                            <form action="{{ route('addWishList', ['product_item' => $productItem->product_item_id]) }}" method="POST">
                                                @csrf
                                                <button class="wishList_btn" style="padding: 0px; cursor: pointer;" onclick="submitAddToWishlist(this)">
                                                    <span class="btn_inner">
                                                        <!-- Wishlist Icon -->
                                                        <div id="success-message"></div>
                                                        <i class="wishList_icon bx bx-heart"></i>
                                                        <input type="hidden" name="productId" value="{{ $productItem->id }}">
                                                    </span>
                                                </button>
                                            </form>
                                        </div>
                                        {{-- <button class="btn" style="padding: 0px; cursor: pointer;" onclick="submitAddToWishlist()">
                                            <i class="heart-icon fas fa-heart" style="font-size: 20px; color: black;"></i>
                                        </button> --}}
                                    </div>
                                </div>
                            </div>       
                                             
                        @endif
                    @empty
                        <div class="wrapper">
                            <h1 class="text-title">No Product Item Available</h1>
                        </div>
                    @endforelse
                </div>
                
                
            </div>
        </div>
            <!-- fullscreen img preview box -->
            <div class="preview-box">
                <div class="details">
                    <span class="title">Image Category: <p></p></span>
                    <span class="icon fas fa-times"></span>
                </div>
                <div class="image-box"><img src="" alt=""></div>
            </div>
            <div class="shadow"></div>

        </div>
<br><br><br><br><br>
        <!-------FOOTER--------->
        @include('layout.footer')
       <!-------FOOTER--------->

    </body>
</html>

<!-- JavaScript to handle click event -->
{{-- <script>
    $(document).ready(function(){
        $(".heart-icon").click(function(){
            $(this).toggleClass("heart-active");
        });
    });
</script>

<style>
    /* Add this style to change the color when the heart-active class is present */
    .heart-active {
        color: red !important;
    }
</style> --}}
<style>
    .wishList_btn.clicked i {
        color: red !important;
    }
</style>

<script>
    function submitAddToWishlist(button) {
        // Toggle the 'clicked' class when the button is clicked
        button.classList.toggle('clicked');

        // Your existing logic here...
    }
</script>