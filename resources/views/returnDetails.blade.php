<!DOCTYPE html>
<html lang="en">
<head>
    <title>YEEKIA | Return And Refund</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('css/returnDetails.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    @include('layout.delivery_layout')

    <!-- EndHeader -->

    <!-- UniIcon CDN Link  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<body>
    <div class="main_container">
        <div class="main_wrapper">
            <div class="main_content">
                <div class="main">
                    <section class="delivery_id_container">
                        <a class="back_btn" href="{{ route('order.getStatusOrder') }}">
                            <i class="back_icon bx bx-chevron-left"></i>
                            <span>Back</span>
                        </a>
                        <div class="delivery_id_grid">
                            <div class="delivery_id">
                                <span class="delivery_id_text">Request ID</span>
                              
                                <span class="delivery_id_number">{{ $order->returnAndRefund->returnAndRefund_id }}</span>
                            </div>
                            <span class="line">|</span>
                            <span class="status_text">{{ strtoupper($order->returnAndRefund->status) }} At: {{ $order->returnAndRefund->updated_at }}</span>
                        </div>
                    </section>
                    <section class="product_container">
                       @foreach ($order->orderDetails as $orderItem)
                        <div class="product_details_container">
                            <div class="item_detail_grid">
                                <div class="image_container">
                                    @php($product_image =  $orderItem->productItem['product_image'])
                                    <img src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" alt="" class="item_image">
                                 
                                </div>
                                <div class="delivery_item_details_container">
                                    <div class="delivery_item_details_grid">
                                        <div class="item_detail_container">
                                            <div class="item_detail_wrapper">
                                                <span class="item_name">
                                                    <a href="" class="item_name_a">
                                                        {{ $orderItem->productItem->product_name }}
                                                    </a>
                                                </span>
                                                <span class="item_detail">
                                                    <div class="category">{{ $orderItem->productItem->category->category_name }}</div>
                                                    <div class="detail">{{ $orderItem->productItem->product_measurement }} cm</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="item_price">
                                            <div class="item_price_wrapper">
                                                <span class="item_price_module">
                                                    <span class="price_currency">RM</span>
                                                    <span class="price_integer">{{ $orderItem->productItem->product_price * $orderItem->quantity }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="items_quantity">
                                            <p class="quantity_text">
                                                Qty:
                                                <span class="quantity_number">{{ $orderItem->quantity }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                    </section>
                    <section class="reason_return_container">
                        <div class="reason_return_wrapper">
                            <div class="reason">
                                <span class="reason_text">Reason:</span>
                                <span class="user_comment">{{ $order->returnAndRefund->reason }}</span>
                            </div>
                            <div class="user_comment_container">
                                <span class="reason_text">
                                    Description:
                                </span>
                                <span class="user_comment">
                                    {{ $order->returnAndRefund->description }}
                                </span>
                            </div>
                            <div class="image_container">
                                <div class="image_wrapper">
                                    <div class="return_proof_image">
                                        @php($evidence =  $order->returnAndRefund['evidence'])
                                        <img src="{{ $evidence ? asset('storage/' .$evidence) : '' }}" alt="" class="proof">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="staff_comment_container">
                                <span class="reason_text">
                                    Comment:
                                </span>
                                <span class="user_comment" style="color: red;">
                                    {{ $order->returnAndRefund->comment }}
                                </span>
                            </div>
                        </div>
                    </section>
                    <section class="summary_container">
                        <div class="summary_wrapper">
                            <div class="summary_text_container">
                                <span class="summary_text">Item Subtotal</span>
                            </div>
                            <div class="summary_price_container">
                                <div class="summary_price">
                                    <span class="price_currency">RM</span>
                                    <span class="price_integer">{{ $order->subtotal }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="summary_wrapper">
                            <div class="summary_text_container">
                                <span class="summary_text">Service Tax</span>
                            </div>
                            <div class="summary_price_container">
                                <div class="summary_price">
                                    <span class="price_currency">RM</span>
                                    <span class="price_integer">{{ $order->serviceTax }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="summary_wrapper">
                            <div class="summary_text_container">
                                <span class="summary_text">Refund Amount</span>
                            </div>
                            <div class="summary_price_container">
                                <div class="summary_price">
                                    <span class="price_currency">RM</span>
                                    <span class="price_integer">{{ $order->totalAmount }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="summary_wrapper">
                            <div class="summary_text_container">
                                <span class="summary_text">Refund to</span>
                            </div>
                            <div class="summary_payment_method_container">
                                <div class="summary_payment_method">
                                    <span class="payment_method">Online Banking</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-------FOOTER--------->

    @include('layout.footer')
    <!-- EndFooter -->
            


</body>
</html>