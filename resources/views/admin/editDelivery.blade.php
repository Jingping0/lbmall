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

<link rel="stylesheet" href="{{ asset('css/admin_edit_order.css') }}">

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
                <label class="title">Edit Delivery</label>
            </div>

            <form method="post" action="{{ route('admin.editDeliveryPost', ['delivery_id' => $delivery->delivery_id]) }}">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Delivery ID</label>
                        <input class="input-field" type="text" id="delivery_id" name="delivery_id" value="{{ old('delivery_id', $delivery->delivery_id) }}"readonly />
                        @error('delivery_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input class="input-field" type="text" id="order_id" name="order_id"  value="{{ old('order_id', $delivery->order_id) }}" readonly/>
                        @error('order_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">address ID</label>
                        <input class="input-field" type="text" id="address_id" name="address_id"  value="{{ old('address_id', $delivery->address_id) }}" readonly/>
                        @error('address_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input class="input-field" type="text" id="username" name="username"  value="{{ old('username', $delivery->username) }}" readonly/>
                        @error('username')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Street</label>
                        <input class="input-field" type="text" id="street" name="street"  value="{{ old('street', $delivery->street) }}" readonly/>
                        @error('street')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Area</label>
                        <input class="input-field" type="text" id="area" name="area"  value="{{ old('area', $delivery->area) }}" readonly/>
                        @error('area')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Postcode</label>
                        <input class="input-field" type="text" id="postcode" name="postcode"  value="{{ old('postcode', $delivery->postcode) }}" readonly/>
                        @error('postcode')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="input-field" type="text" id="phone" name="phone"  value="{{ old('phone', $delivery->phone) }}" readonly/>
                        @error('phone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="#" selected="true" disabled="true">Select the Status</option>
                            <option value="Collected" {{ old('status', $delivery->status) == 'Collected' ? 'selected' : '' }}>Collected</option>
                            <option value="Shipping" {{ old('status', $delivery->status) == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                            <option value="OutOfShipping" {{ old('status', $delivery->status) == 'OutOfShipping' ? 'selected' : '' }}>Out Of Shipping</option>
                            <option value="Arrival" {{ old('status', $delivery->status) == 'Arrival' ? 'selected' : '' }}>Arrival</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

                    <div class="edit_user_btn_group">
                        <a href="{{ route('admin.showDeliveryList') }} " class="btn btn-danger">Back</a>
                        <button type="submit" class="btn">Edit Delivery</button>
                    </div>
            </form>
            
        
            <script>
                tinymce.init({
                     selector: '#txtA_content',
                     height: 300
                   });
            
            </script>
            <script>
                var state= false;
                function toggle(){
                    if(state){
                        document.getElementById("password").setAttribute("type","password");
                        document.getElementById("eye").setAttribute("class","icon fa fa-eye")
                        state = false;
                    }
                    else{
                        document.getElementById("password").setAttribute("type","text");
                        document.getElementById("eye").setAttribute("class","icon fa fa-eye-slash")
                        state = true;
                    }
                }
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