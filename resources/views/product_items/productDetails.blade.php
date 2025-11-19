<!DOCTYPE html>
<html>
 @include('layout.subNav')

</head>

<body>
    <div class="content">
        <div class = "card-wrapper">
            <form action="{{ route('cart.addProductItem', ['product_item' => $productItem->product_item_id]) }}" method="POST" onsubmit="return confirmAddToCart()">
                @csrf
                <div class = "card">
                    <!-- card left -->
                    <div class = "product-imgs">
                        <div class = "img-display">
                            <div class = "img-showcase">
                                @php($product_image =  $productItem['product_image'])
                                <img src=  "{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                                @php($product_subImage1 =  $productItem['product_subImage1'])
                                <img src=  "{{ $product_subImage1 ? asset('storage/' .$product_subImage1) : '' }}" />
                                @php($product_subImage2 =  $productItem['product_subImage2'])
                                <img src=  "{{ $product_subImage2 ? asset('storage/' .$product_subImage2) : '' }}" />
                                @php($product_subImage3 =  $productItem['product_subImage3'])
                                <img src=  "{{ $product_subImage3 ? asset('storage/' .$product_subImage3) : '' }}" />
                            </div>
                        </div>
    
                        <!-- Selected Product Image -->
                    <div class = "img-select"> 
                        <div class = "img-item">
                            <a href = "#" data-id = 1>
                                <img src=  "{{ $product_image ? asset('storage/' .$product_image) : '' }}" />
                            </a>
                        </div>
                        <div class = "img-item">
                            <a href = "#" data-id = 2>
                                <img src=  "{{ $product_subImage1 ? asset('storage/' .$product_subImage1) : '' }}" />
                            </a>
                        </div>
                        <div class = "img-item">
                            <a href = "#" data-id = 3>
                                <img src=  "{{ $product_subImage2 ? asset('storage/' .$product_subImage2) : '' }}" />
                            </a>
                        </div>
                        <div class = "img-item">
                            <a href = "#" data-id = 4>
                                <img src=  "{{ $product_subImage3 ? asset('storage/' .$product_subImage3) : '' }}" />
                            </a>
                        </div> 
                        </div>
                    </div>

                    <!-- card right -->
                    <div class = "product-content">
                        <!-- Product name -->
                        <input type="hidden" name="prodId" value="1001" />
                        <h2 class = "product-title">{{ $productItem->product_name }}</h2>
                        <p class="lenght_info">Single</p>
                        <div class = "product-rating">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <span>Note that the product can be returned if damaged.</span>
                        </div>
    
                        <!-- Product Price -->
                        <div class = "product-price">
                            <p class = "new-price"><span class="rm">RM</span>
                                <span class="product_price">{{ number_format($productItem->product_price, 2) }}</span>
                            </p>
                        </div>
    
                        <!-- Product Description -->
                        <div class = "product-detail">
                            <h2>About this product: </h2>
                            <p>{{ $productItem->product_desc }}</p>
                        </div>

    
                        <!-- Size/Dimension -->
                        <div class="measurement">
                            <h2>Measurement:</h2>
                            <p><strong>{{ $productItem->product_measurement }}cm</strong></p>
                        </div>

                        <div class="available">
                            <h2>Stock:  <strong>{{ $productItem->available }}</strong>      </h2>
                        </div>
    
                        <div class = "purchase-info">
                                <input type = "number" id="quantity" name="quantity" min ="1" max="{{ $productItem->available }}" value="1" />       
                                <button type="submit" class="btn">Add to Cart</button>
                        </div>

                        <div class="more-info">
                            <i class="fa fa-truck"></i>
                            <span>Free deliver to your house</span>
                            <hr>
                            <i class="fas fa-wrench"></i>
                            <span>Have it assembled for you</span>
                            <hr>
                            <i class="fa fa-warehouse"></i>
                            <!-- Display out of stock -->
                            
                            <span>Currently out of stock</span>
                            
                            <!-- Display available -->
                            <span>Product available</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="review_container">
        <div class="review_wrapper">
            <h1 class="review_title">Review</h1>
        </div>
        <div class="review_star_filter_container">
            <div class="review_star_filter">
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">All</span>
                </span>
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">1 Star</span>
                </span>
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">2 Star</span>
                </span>
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">3 Star</span>
                </span>
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">4 Star</span>
                </span>
                <span class="review_filter_item_container">
                    <span class="review_filter_text" data-name="all">5 Star</span>
                </span>
            </div>

            
                @foreach ($productItem->ratings as $rating)
                @if ($rating->rating_status === 'rate')
                <div class="review_comment_container">
                    <div class="review_comment">
                        <div class="user_info_container">
                            <div class="user_info_wrapper">
                                @php($userImage =  $rating->customer['userImage'])
                                <img class="user_image" src="{{ $userImage ? asset('storage/' .$userImage) : asset('storage/userImage/userProfile.png') }}" alt="">
                                <h3 class="user_name">{{ $rating->customer->username }}</h3>
                            </div>

                            <div class="rating_info">
                                <div class="rating_date">{{ $rating->created_at->format('Y-m-d H:i:s') }}</div>
                                <div class="line_review">|</div>
                                <div class="review_star">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating->rating_value)
                                            <i class="star_icon fa fa-star"style="color: #fd4;"></i>
                                        @else
                                            <i class="star_icon fa fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="review_info">
                        </div>
                        <div class="comment_text_container">
                            <p class="comment_text">
                               {{ $rating->rating_comment }}
                            </p>
                        </div>
                    
                        <div class="prof_image_container">
                            <div class="prof_image_wrapper">
                                <img class="proof_image" src="{{ asset('storage/'.$rating->rating_image) }}">
                          
                            </div>
                        </div>
                    </div>
                </div>    
                @endif   

                @endforeach
            
        </div>
    </div>
    
        <script>
            const imgs = document.querySelectorAll('.img-select a');
            const imgBtns = [...imgs];
            let imgId = 1;
    
            imgBtns.forEach((imgItem) => {
                imgItem.addEventListener('click', (event) => {
                    event.preventDefault();
                    imgId = imgItem.dataset.id;
                    slideImage();
                });
            });
    
            function slideImage() {
                const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
    
                document.querySelector('.img-showcase').style.transform = translateX(${- (imgId - 1) * displayWidth}px);
            }
    
            window.addEventListener('resize', slideImage);
    
        </script>

        <script>
            function confirmAddToCart() {
                return confirm('Are you sure you want to add this item to the cart?');
            }
        </script>
        
        <script>
            const imgs = document.querySelectorAll('.img-select a');
            const imgBtns = [...imgs];
            let imgId = 1;
    
            imgBtns.forEach((imgItem) => {
                imgItem.addEventListener('click', (event) => {
                    event.preventDefault();
                    imgId = imgItem.dataset.id;
                    slideImage();
                });
            });
    
            function slideImage() {
                const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;
    
                document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
            }
    
            window.addEventListener('resize', slideImage);
    
        </script>

        <script>
            function confirmAddToCart() {
                return confirm('Are you sure you want to add this item to the cart?');
            }
        </script>

<!-------FOOTER--------->

@include('layout.footer')

<!-- EndFooter -->


</body>
</html>