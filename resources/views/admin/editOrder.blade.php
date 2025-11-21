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
                <label class="title">Edit Order</label>
            </div>

            <form method="post" action="{{ route('admin.editOrderPost', ['order_id' => $order->order_id]) }}">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input class="input-field" type="text" id="orderId" name="orderId" value="{{ old('orderId', $order->order_id) }}"readonly />
                        @error('orderId')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer ID</label>
                        <input class="input-field" type="text" id="customer_id" name="customer_id"  value="{{ old('customer_id', $order->customer_id) }}" readonly/>
                        @error('customer_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input class="input-field" type="text" id="totalAmount" name="totalAmount"  value="{{ old('totalAmount', $order->totalAmount) }}" readonly/>
                        @error('totalAmount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order Date</label>
                        <div  class="input-fields">
                            <input class="date_input" type="date" id="orderDate" name="orderDate" value="{{ old('orderDate', $order->orderDate) }}" readonly/>
                        </div>
                        @error('orderDate')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Staff ID</label>
                        <input class="input-field" type="text" id="staff_id" name="staff_id"  value="{{ old('staff_id', $order->staff_id) }}" readonly/>
                        @error('staff_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Created At</label>
                        <input class="input-field" type="datetime-local" id="created_at" name="created_at"  value="{{ old('created_at', $order->created_at) }}" readonly/>
                        @error('created_at')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Updated At</label>
                        <input class="input-field" type="datetime-local" id="updated_at" name="updated_at"  value="{{ old('updated_at', $order->updated_at) }}" readonly/>
                        @error('updated_at')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="#" selected="true" disabled="true">Select the Status</option>
                            <option value="Preparing" {{ old('status', $order->status) == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Shipping" {{ old('status', $order->status) == 'Shipping' ? 'selected' : '' }}>Shipping</option>
                            <option value="Receiving" {{ old('status', $order->status) == 'Receiving' ? 'selected' : '' }}>Receiving</option>
                            <option value="Completed" {{ old('status', $order->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $order->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="ReturnAndRefund" {{ old('status', $order->status) == 'ReturnAndRefund' ? 'selected' : '' }}>Return and Refund</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

                    <div class="edit_user_btn_group">
                        <a href="{{ route('admin.showOrderList') }} " class="btn btn-danger">Back</a>
                        <button type="submit" class="btn">Edit Order</button>
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