<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeekia | Delivery Tracking</title>
    <link rel="stylesheet" href="{{ asset('css/deliveryTracking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <!-- UniIcon CDN Link  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

@include('layout.delivery_layout')


<body>
    <div class="root">
        
    <div class="main_container">
        <h1 class="delivery_title" for="">Delivery Tracking</h1>
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
                                <span class="delivery_id_text">Delivery ID</span>
                                <span class="delivery_id_number">:{{ $delivery ? $delivery->delivery_id : 'N/A' }}</span>
                            </div>
                            <span class="lines">|</span>
                            <span class="status_text">YOUR ORDER HAS BEEN {{ strtoupper($delivery->status) }}</span>
                        </div>
                    </section>
                    <section class="delivery_status_container">
                        <div class="delivery_status_grid">
                            <ul class="delivery_ul">
                                <li>
                                    <i class="icon uil uil-clipboard-notes"></i>
                                    <div class="progress one{{ $delivery && ($delivery->status == 'Collected' || $delivery->status == 'Shipping' || $delivery->status == 'OutOfShipping' || $delivery->status == 'Arrival') ? ' active' : '' }}">
                                        <p>1</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Parcel Collected</p>
                                </li>
                                <li>
                                    <i class="icon uil uil-truck"></i>
                                    <div class="progress two{{ $delivery && ($delivery->status == 'Shipping' || $delivery->status == 'OutOfShipping' || $delivery->status == 'Arrival') ? ' active' : '' }}">
                                        <p>2</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Parcel Shipped</p>
                                </li>
                                <li>
                                    <i class="icon uil uil-credit-card"></i>
                                    <div class="progress three{{ $delivery && ($delivery->status == 'OutOfShipping' || $delivery->status == 'Arrival') ? ' active' : '' }}">
                                        <p>3</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Parcel Out of Delivery</p>
                                </li>
                                <li>
                                    <i class="icon uil uil-map-marker"></i>
                                    <div class="progress four{{ $delivery && $delivery->status == 'Arrival' ? ' active' : '' }}">
                                        <p>4</p>
                                        <i class="uil uil-check"></i>
                                    </div>
                                    <p class="text">Parcel Arrival </p>
                                </li>
                            </ul>
                        </div>
                    </section>
                    <section class="product_container">
                    @foreach ($order->orderDetails as $item)
                        <div class="product_details_container">
                            <div class="item_detail_grid">
                                <div class="image_container">
                                    @php($product_image =  $item->productItem['product_image'])
                                    <img src="{{ $product_image ? asset('storage/' .$product_image) : '' }}" alt="" class="item_image">
                                </div>
                                <div class="delivery_item_details_container">
                                    <div class="delivery_item_details_grid">
                                        <div class="item_detail_container">
                                            <div class="item_detail_wrapper">
                                                <span class="item_name">
                                                    <a href="" class="item_name_a">
                                                        {{ $item->productItem->product_name }}
                                                    </a>
                                                </span>
                                                <span class="item_detail">
                                                    <div class="category">{{ $item->productItem->category->category_name }}</div>
                                                    <div class="detail">{{ $item->productItem->product_measurement }} cm</div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="item_price">
                                            <div class="item_price_wrapper">
                                                <span class="item_price_module">
                                                    <span class="price_currency">RM</span>
                                                    <span class="price_integer">{{ $item->productItem->product_price * $item->quantity }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="items_quantity">
                                            <p class="quantity_text">
                                                Qty:
                                                <span class="quantity_number">{{ $item->quantity }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </section>
                    <section class="summary_container">
                        <div class="summary_wrapper">
                            <div class="summary_text_container">
                                <span class="summary_text">Merchandise Subtotal</span>
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
                                <span class="summary_text">Service Tax ( 6% )</span>
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
                                <span class="summary_text">Order Total</span>
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
                                <span class="summary_text">Payment Method</span>
                            </div>
                            <div class="summary_payment_method_container">
                                <div class="summary_payment_method">
                                    <span class="payment_method">Cash On Delivery</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('layout.footer')

</body>
</html>
