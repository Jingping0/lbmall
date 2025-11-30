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

<link rel="stylesheet" href="{{ asset('css/admin_add_user.css') }}">
<link rel="stylesheet" href="{{ asset('css/delete.css') }}">

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
                <label class="title">Edit Return and Refund</label>
            </div>

            <form method="post" action="{{ route('admin.editReturnPost', ['returnAndRefund_id' => $return->returnAndRefund_id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Return ID</label>
                        <input class="input-field" type="text" id="returnAndRefund_id" name="returnAndRefund_id" value="{{ old('returnAndRefund_id', $return->returnAndRefund_id) }}"readonly />
                        @error('returnAndRefund_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input class="input-field" type="text" id="order_id" name="order_id"  value="{{ old('order_id', $return->order_id) }}" readonly/>
                        @error('order_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Customer ID</label>
                        <input class="input-field" type="text" id="customer_id" name="customer_id"  value="{{ old('customer_id', $return->customer_id) }}" readonly/>
                        @error('customer_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Request Date</label>
                        <div  class="input-field">
                            <input type="datetime-local" id="created_at" name="created_at" value="{{ old('created_at', $return->created_at) }}" readonly/>
                        </div>
                        @error('created_at')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Reason</label>
                        <select class="form-select" id="reason" name="reason">
                            <option value="#" selected="true" disabled="true">Select the Reason</option>
                            <option value="Missing" {{ old('reason', $return->reason) == 'Missing' ? 'selected' : '' }}>Missing</option>
                            <option value="Wrong Item" {{ old('reason', $return->reason) == 'Wrong Item' ? 'selected' : '' }}>Wrong Item</option>
                            <option value="Damage Item" {{ old('reason', $return->reason) == 'Damage Item' ? 'selected' : '' }}>Damage Item</option>
                        </select>
                        @error('reason')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Desciption</label>
                        <input class="input-field" type="text" id="description" name="description"  value="{{ old('description', $return->description) }}" />
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 5px;">Evidence Image</label>
                        <div class="drop-zone">
                            <span class="drop-text">
                                @if($return->evidence)
                                    <img src="{{ asset('storage/' . $return->evidence) }}" alt="Old Image" style="margin-top:-50px; width:150px; height:130px;">
                                @else
                                    Drag and Drop your image
                                @endif
                            </span>
                                <input class="image-field" type="file" id="evidence" name="evidence" value="Drag and Drop your image" accept="image/*" onchange="previewImage(this, 'mainImagePreview')" multiple/>
                            <div id="mainImagePreview" class="image-preview"></div>
                            @error('evidence')
                                <div class="error-message" >{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="#" selected="true" disabled="true">Select the Status</option>
                            <option value="pending" {{ old('status', $return->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status', $return->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ old('status', $return->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <input class="input-field" type="text" id="comment" name="comment"  value="{{ old('comment', $return->comment) }}" />
                        @error('comment')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

                    <div class="add_user_btn_group">
                        <a href="{{ route('admin.showReturnList') }} " class="btn btn-danger">Back</a>
                        <button type="submit" class="btn">Edit Return Detail</button>
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