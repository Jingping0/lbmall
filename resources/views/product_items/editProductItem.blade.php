@extends('layout.admin_layout')

@section('css')
<style>
    .main{
        padding: 20px;
    }
    
</style>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<link rel="stylesheet" href="{{ asset('css/admin_add_product.css') }}">

<style>
        .error-message {
        color: red;
        margin-top: 5px;
    }

</style>

<div class="container">
    <div class="row">
        <div class="container">
            <div class="container-title">
                <label class="title">Edit Product</label>
            </div>

            <form method="post" action="{{ route('product_items.editProductItemPost', ['product_item_id' => $productItem->product_item_id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="input-field" type="text" id="product_name" name="product_name" value="{{ old('product_name', $productItem->product_name) }}" />
                        @error('product_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Price (RM)</label>
                        <input class="input-field" type="text" id="product_price" name="product_price" pattern="\d+(\.\d{2})?" value="{{ old('product_price', $productItem->product_price) }}" />
                        @error('product_price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="" selected disabled>Select the Category</option>
                            <option value="9001" @if(old('category_id', $productItem->category_id) == '9001') selected @endif>Table</option>
                            <option value="9002" @if(old('category_id', $productItem->category_id) == '9002') selected @endif>Chair</option>
                            <option value="9003" @if(old('category_id', $productItem->category_id) == '9003') selected @endif>Wardrobe</option>
                            <option value="9004" @if(old('category_id', $productItem->category_id) == '9004') selected @endif>Bed</option>
                            <option value="9005" @if(old('category_id', $productItem->category_id) == '9005') selected @endif>Curtain</option>
                            <!-- Add more options as needed -->
                        </select>
                        @error('category_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Available</label>
                        <input class="input-field" inputmode="numeric" type="number" id="available" name="available" min="1" max="999" value="{{ old('available', $productItem->available) }}" />
                        @error('available')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea type="text" id="product_desc" name="product_desc" style="width: 610px;height:100px;" >{{ old('product_desc', $productItem->product_desc) }}</textarea>
                        @error('product_desc')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                    <div class="mb-3">
                        <label class="form-label">Measurement (cm)</label>
                        <p><input class="input-field" type="text" id="product_measurement" name="product_measurement" 
                            style="height: 45px; width: 48%;outline: none;border-radius: 5px;border: 1px solid #ccc;padding-left: 10px;"
                            value="{{ old('product_measurement', $productItem->product_measurement) }}" /></p>
                        @error('product_measurement')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
            </div>

                <div class="mb-3">
                    <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 5px;">Main Image</label>
                    <div class="drop-zone">
                        <span class="drop-text">
                            @if($productItem->product_image)
                                <img src="{{ asset('storage/' . $productItem->product_image) }}" alt="Old Image" style="margin-top:-50px; width:150px; height:130px;">
                            @else
                                Drag and Drop your image
                            @endif
                        </span>
                            <input class="image-field" type="file" id="product_image" name="product_image" value="Drag and Drop your image" accept="image/*" onchange="previewImage(this, 'mainImagePreview')" multiple/>
                        <div id="mainImagePreview" class="image-preview"></div>
                        @error('product_image')
                            <div class="error-message" >{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="sub-image" style="margin-top: 50px;">
                    <div class="mb-3">
                        <div class="sub-drop-zone">
                            <span class="sub-drop-text">Image 1</span>
                            <span class="sub-drop-text">
                                @if($productItem->product_subImage1)
                                    <img src="{{ asset('storage/' . $productItem->product_subImage1) }}" alt="Old Image" style="margin-left:-45px; margin-top:-50px; width:150px; height:130px;">
                                @else
                                    Image 1
                                @endif
                            </span>
                            <input class="sub-image-field" type="file" id="product_subImage1" name="product_subImage1" accept="image/*" onchange="previewImage(this, 'subImagePreview1')" />
                            <div id="subImagePreview1" class="image-preview"></div>
                            @error('product_subImage1')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="mb-3">
                        <div class="sub-drop-zone">
                            <span class="sub-drop-text">
                                @if($productItem->product_subImage2)
                                    <img src="{{ asset('storage/' . $productItem->product_subImage2) }}" alt="Old Image" style="margin-left:-45px; margin-top:-50px; width:150px; height:130px;">
                                @else
                                    Image 2
                                @endif
                            </span>
                            <input class="sub-image-field" type="file" id="product_subImage3" name="product_subImage3" accept="image/*" onchange="previewImage(this, 'subImagePreview3')" />
                            <div id="subImagePreview3" class="image-preview"></div>
                            @error('product_subImage3')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="sub-drop-zone">
                            <span class="sub-drop-text">
                                @if($productItem->product_subImage3)
                                    <img src="{{ asset('storage/' . $productItem->product_subImage3) }}" alt="Old Image" style="margin-left:-45px; margin-top:-50px; width:150px; height:130px;">
                                @else
                                    Image 3
                                @endif
                            </span>
                            <input class="sub-image-field" type="file" id="product_subImage2" name="product_subImage2" accept="image/*" onchange="previewImage(this, 'subImagePreview2')" />
                            <div id="subImagePreview2" class="image-preview"></div>
                            @error('product_subImage2')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
     
                <div class="btn-groups">
                    <button type="submit" class="add_product_btn">Edit</button>
                    <a class="add_product_btn" href="{{ route('product_items.showProductList') }} " class="btn btn-danger">Cancel</a>
                </div>
            </form>
            
        
            <script>
                tinymce.init({
                     selector: '#txtA_content',
                     height: 300
                   });
            
            </script>
           <script>
            function previewImage(input, previewId) {
                var preview = document.getElementById(previewId);
                var dropZone = preview.parentElement;
        
                // Clear existing previews
                while (preview.firstChild) {
                    preview.removeChild(preview.firstChild);
                }
        
                if (input.files && input.files.length > 0) {
                    for (var i = 0; i < input.files.length; i++) {
                        var reader = new FileReader();
        
                        reader.onload = function (e) {
                            var image = document.createElement('img');
                            // image.src = e.target.result;
                            // image.alt = 'Image Preview';
                            // image.style.maxWidth = '100%';
                            // image.style.maxHeight = '150px';
                            // preview.appendChild(image);
        
                            // Set the background image for the sub-drop-zone
                            dropZone.style.backgroundImage = 'url(' + e.target.result + ')';
                            dropZone.style.backgroundSize = 'cover';
                            dropZone.style.backgroundPosition = 'center';
                        };
        
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            }
        </script>
            
        </div>
    </div>
</div>
@endsection