<!DOCTYPE html>
<html>

<head>
    <title>Orders</title>
    @include('layout.subNav')

    <!-- fontawesome -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- End fontawesome -->

    <style>
        .wrapperT {
            position: fixed;
            top: 30px;
            right: 20px;
          }
          
          .custom-toast {
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
          
          .custom-toast-success {
            width: 100%;
            height: 70px;
            padding: 20px;
            background: #fff;
            box-shadow: 2px 9px 12px #0002;
            border-radius: 7px;
            text-align: center;
            border-left: 8px solid #04c127;
          }
          
          .custom-toast .containerT {
            display: flex;
            align-items: center;
            justify-content: center;
          }
          
          .custom-toast .icon i {
            font-size: 1.75rem;
            color: #04c127;
          }
          
          .custom-toast .message {
            font-size: 1.07rem;
            margin-left: 12px;
            flex: 1;
          }
          
          .custom-toast .close-icon i {
            color: #aeb0d7;
            cursor: pointer;
            margin-left: 1rem;
            font-size: 25px;
          }
          
          .custom-toast .close-icon i:hover {
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
      </style>
      
      <link rel="stylesheet" href="{{ asset('css/myPurchase.css') }}"/>
      </head>
      
      @if (session('success'))
      <div class="wrapperT">
          <div class="custom-toast custom-toast-success" id="my-container">
              <div class="containerT">
                  <span class="icon">
                      <i class='bx bx-check-circle'></i>
                  </span>
                  <div id="my-message" role="alert">
                      <span class="message">{{ session('success') }}</span>
                  </div>
                  <span class="close-icon" onclick="closeToast()">
                      <i class='bx bx-x'></i>
                  </span>
              </div>
          </div>
      </div>
      
<script>

</script>
@endif

<body>



    <div class="purchase_container">
        <div class="purchase_container_grid">
            <div class="purchase_main_content">
                <div class="purchase_content">
                    <section class="purchase_filter">
                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'all' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'all']) }}" data-name="all">All</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'Preparing' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'Preparing']) }}" data-name="Preparing">Preparing</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'Shipping' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'Shipping']) }}" data-name="Shipping">Shipping</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'Receiving' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'Receiving']) }}" data-name="Receiving">Receiving</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'Completed' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'Completed']) }}" data-name="Completed">Completed</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'Cancelled' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'Cancelled']) }}" data-name="Cancelled">Cancelled</a>
                        </span>

                        <span class="filter_item_container">
                            <a class="filter_text {{ request()->input('status') === 'ReturnAndRefund' ? 'active' : '' }}" href="{{ route('order.getStatusOrder', ['status' => 'ReturnAndRefund']) }}" data-name="ReturnAndRefund">Return and Refund</a>
                        </span>
                    </section>

    
    


                    <section class="serach_purchase_item_container">
                        <div class="serach_purchase_item_size">
                            <div class="icon_container">
                                <i class='search_icon bx bx-search'></i>
                            </div>
                            <input class="search_input" type="text" placeholder="You can search by name">
                        </div>
                    </section>

                    @if ($orders->isEmpty())
                    <div>
                        <h4>You don't have any odrer yet.</h4>
                    </div>
                    @else
            
                    @if (session('success'))
                    <div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="liveToast" class="toast d-flex" role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 0; transition: opacity 0.3s ease-in-out;">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                    @foreach ($orders as $order)

                    <div class="modal fade" id="ratingModal_{{ $order->order_id }}" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="header-content">
                                        <h5 class="modal-title" id="ratingModalLabel">Rating</h5>
                                        <label for="" class="product-label">Select a product to review.</label>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($order->orderDetails as $orderDetail)
                                 
                                    {{-- @if( $orderDetail->rating->rating_status === 'unrate') --}}
                                   
                                    <a href="{{ route('ratings.updateRating', $orderDetail->productItem->product_item_id) }}">
                                    <div class="rating_product_container">
                                        <div class="rating_product_grid">
                                            <div class="image_container">
                                                
                                                @php($product_image =  $orderDetail->productItem['product_image'])
                                                <img class="rating_product_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                            </div>
                                            <div class="rating_product_details_container">
                                                <div class="rating_product_details_grid">
                                                    <div class="item_detail_container">
                                                        <div class="item_detail_wrapper">
                                                            <span class="item_name">
                                                                <a href="" class="item_name_a">
                                                                    {{ $orderDetail->productItem->product_name }}
                                                                </a>
                                                            </span>
                                                            <span class="item_detail">
                                                                <div class="category">{{ $orderDetail->productItem->category->category_name }}</div>
                                                                <div class="detail">{{ $orderDetail->productItem->product_measurement }}</div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="items_quantity">
                                                        <p class="quantity_text">
                                                            Qty:
                                                            <span class="quantity_number">{{ $orderDetail->quantity }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                {{-- @endif --}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main_content">
                        <div class="item_details_container">
                            <div class="item_container" data-name="Cancel">

                                
                                <div class="user_purchase_item_container" >
                                    <section class="status_container">
                                        <div class="status_grid">
                                            <div class="status_wrapper">
                                                <label class="order_id">Order ID: {{ $order->order_id }}</label>
                                                <span class="status">{{ $order->status }}</span>
                                            </div>
                                        </div>
                                    </section>                                    
                                    @foreach ($order->orderDetails as $orderDetail)
                                    <div class="user_purchase_item_grid">
                                        <section class="item_content_detail_container">
                                            <a href="" class="item_content_detail_a">
                                                <div class="item_content_detail_div">
                                                    <div class="item_content_detail_div2">
                                                        <div class="item_content_detail_div3">
                                                            
                                                            <section class="item_content_detail_section">
                                                                
                                                                <div class="item_content_detail_grid">
                                                                
                                                                    <div class="item_detail_grid">
                                                                        <div class="image_container">
                                                                            @php($product_image =  $orderDetail->productItem['product_image'])
                                                                            <img class="item_image" src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                                                        </div>
                                                                        <div class="item_detail">
                                                                            <div class="item_name_contaier">
                                                                                <div class="item_name_grid">
                                                                                    <span class="item_name">{{ $orderDetail->productItem->product_name }}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="items_details_contaiers">
                                                                                <div class="items_details_wrapper">
                                                                                    <span class="category">{{ $orderDetail->productItem->category->category_desc }}</span>
                                                                                    <span class="details">{{ $orderDetail->productItem->product_measurement }} cm</span>
                                                                                </div>
                                                                                <div class="items_quantity">
                                                                                    <p class="quantity_text">
                                                                                        Qty:
                                                                                        <span class="quantity_number">{{ $orderDetail->quantity }}</span>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>  
                                                                    <div class="item_price_container">
                                                                        <div class="item_price_grid">
                                                                            <span class="price_currency">RM</span>
                                                                            <span class="price_integer">{{ ($orderDetail->productItem->product_price * $orderDetail->quantity) }}</span>
                                                                        </div>
                                                                    </div>
                                                               
                                                                </div>
                                                                
                                                            </section>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </section>
                                    </div>
                                    @endforeach
                                </div>
                                

                                <div class="subtotal_price_container" data-name="cancel">
                                    <label for="" class="subtotal_text">Subtotal</label>
                                    <div class="subtotal_price_grid">
                                        <span class="subtotal_price_currency">RM</span>
                                        <span class="subtotal_price_integer">{{ $order->totalAmount }}</span>
                                    </div>
                                </div>

                                <div class="button_container" data-name="cancel">
                                    <section class="button_grid">
                                        <div class="buyAgain_container">                           
                                        @if ($order->status === 'Preparing')
                                            <form action="{{ route('orders.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="cancel">
                                                <div class="buyAgain_wrapper">
                                                    <button type="submit" class="buyAgain_btn">Cancel Order</button>
                                                </div>
                                            </form>
                                        @elseif ($order->status === 'Shipping')
                                            <div class="buyAgain_wrapper">
                                                <form action="{{ route('orders.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="action" value="delivery">
                                                    <div class="buyAgain_wrapper">
                                                        <button type="submit" class="buyAgain_btn">Delivery Tracking</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @elseif ($order->status === 'Receiving')
                                            
                                            <form action="{{ route('orders.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="received">
                                                <div class="buyAgain_wrapper">
                                                    <button type="submit" class="buyAgain_btn">Order Received</button>
                                                </div> 
                                            </form>
                                            <form action="{{ route('orders.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="action" value="returnAndRefund">
                                                <div class="buyAgain_wrapper">
                                                    <button type="submit" class="buyAgain_btn">Return and Refund</button>
                                                </div>
                                            </form>
                                            
                                         @elseif ($order->status === 'Completed')
                                            <div class="buyAgain_wrapper">
                                                <button class="buyAgain_btn" data-bs-toggle="modal" data-bs-target="#ratingModal_{{ $order->order_id }}">Rate</button>
                                            </div>    
                                        @elseif ($order->status === 'Cancelled')
                                            <div class="buyAgain_wrapper">
                                                <button class="buyAgain_btn">Buy Agian</button>
                                            </div>   
                                        @else
                                            <div class="buyAgain_wrapper">
                                                <form action="{{ route('orders.updateOrderStatus', ['orderId' => $order->order_id]) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="action" value="refundDetail">
                                                    <div class="buyAgain_wrapper">
                                                        <button type="submit" class="buyAgain_btn">Return Details</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif                                         
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<!-------FOOTER--------->

@include('layout.footer')

<!-- EndFooter -->


</body>
</html>


<script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.querySelector('.search_input');
            var searchIcon = document.querySelector('.search_icon');

            // Function to change color on focus
            function handleFocus() {
                searchIcon.style.color = '#555'; // Change it to the desired color
            }

            // Function to change color on blur
            function handleBlur() {
                searchIcon.style.color = '#bbb'; // Set it back to the initial color
            }

            // Add focus and blur event listeners
            searchInput.addEventListener('focus', handleFocus);
            searchInput.addEventListener('blur', handleBlur);
        });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.querySelector('.search_input');
        var searchIcon = document.querySelector('.search_icon');
        var itemContainers = document.querySelectorAll('.user_purchase_item_container');

        // Function to change color on focus
        function handleFocus() {
            searchIcon.style.color = '#555';
        }

        // Function to change color on blur
        function handleBlur() {
            searchIcon.style.color = '#bbb';
        }

        // Add focus and blur event listeners
        searchInput.addEventListener('focus', handleFocus);
        searchInput.addEventListener('blur', handleBlur);

        // Add input event listener for search functionality
        searchInput.addEventListener('input', function () {
            var searchTerm = searchInput.value.toLowerCase();

            itemContainers.forEach(function (itemContainer) {
                var itemName = itemContainer.querySelector('.item_name').innerText.toLowerCase();

                // Check if the item name contains the search term
                if (itemName.includes(searchTerm)) {
                    itemContainer.style.display = 'block'; // Show the item
                } else {
                    itemContainer.style.display = 'none'; // Hide the item
                }
            });
        });
    });
</script>

    


