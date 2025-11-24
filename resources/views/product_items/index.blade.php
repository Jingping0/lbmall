<!DOCTYPE html>
<html lang="en">

    <!-- Header -->
    @include('layout.subNav')

    @if (!isset(auth()->user()->user_id))
    <h1 class="text-title" style="margin-left: 50px;">LB Products</h1>
    <div class="alert alert-secondary" role="alert" style="margin-left: 50px;">
        Please login to continue, 
        <a href="{{ route('login') }}" class="text-right font-weight-bold">Click here</a>
        <br>
        <br>
        {{-- Need to change the route to login --}}
    </div>
    
    @endif
    @section('content')
    </head>
    <body>
        <div class="content">
                
            
            <div class="wrapper">
                <h1 class="text-title">LB Products</h1>
                <!-- filter Items -->
                <nav>
                    <div class="items">
                        <a href="{{ route('product_items.index') }}" class="item active {{ !request('category') ? 'active' : '' }}">{{ __('All') }}</a>

                        @foreach($categories as $category)
                        @php
                            $product_items = $category->productItems()->get();
                        @endphp
                        @if(count($product_items) > 0)
                            <li class="nav-item">
                                <a href="{{ route('product_items.index', ['category' => $category->category_id]) }}" class="nav-link {{ request('category') == $category->category_id ? 'active fw-bold' : '' }}">{{ $category->category_name }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <span class="nav-link disabled">{{ $category->category_name }}</span></span>
                            </li>
                        @endif
                    @endforeach   
                    </div>
                </nav>

                <div class="gallery">
                    @forelse ($productItems as $productItem)
                        @if ($productItem->available)
                            <div class="image" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); ">
                                <form action="{{ route('product.details', ['product_item_id' => $productItem->product_item_id]) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="prodId">
                                    <button type="submit" name="" style="background: none; border: none;">
                                        <span><img src="img/table1.avif" alt=""></span>
                                        <div class="product-detail" style="height: fit-content; text-align: justify;">
                                            <table>
                                                <tr><h1>{{ $productItem->item_name }}</h1></tr>
                                                <tr>{{ $productItem->description }}</tr>
                                                <tr><h2>RM {{ $productItem->price }}</h2></tr>
                                            </table>
                                        </div>
                                    </button>
                                </form>
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

@endsection

        <!-------FOOTER--------->

        @include('layout.footer')

    </body>
</html>
