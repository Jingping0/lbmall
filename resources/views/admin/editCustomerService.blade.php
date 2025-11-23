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
                <label class="title">Edit Customer Service</label>
            </div>

            <form method="post" action="{{ route('contact.editCustomerServicePost', ['cust_service_id' => $request->cust_service_id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Customer Service ID</label>
                        <input class="input-field" type="text" id="cust_service_id" name="cust_service_id" value="{{ old('cust_service_id', $request->cust_service_id) }}"readonly />
                        @error('cust_service_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer ID</label>
                        <input class="input-field" type="text" id="customer_id" name="customer_id"  value="{{ old('customer_id', $request->customer_id) }}" readonly/>
                        @error('customer_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Issue Type</label>
                        <input class="input-field" type="text" id="issue_type" name="issue_type"  value="{{ old('issue_type', $request->issue_type) }}" readonly/>
                        @error('issue_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <div  class="input-field">
                            <input type="text" id="cust_service_desc" name="cust_service_desc" value="{{ old('cust_service_desc', $request->cust_service_desc) }}" readonly/>
                        </div>
                        @error('cust_service_desc')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 5px;">Main Image</label>
                        <div class="drop-zone">
                            <span class="drop-text">
                                @if($request->cust_service_image)
                                    <img src="{{ asset('storage/' . $request->cust_service_image) }}" alt="Old Image" style="margin-top:-50px; width:150px; height:130px;">
                                @else
                                    No Image
                                @endif
                            </span>
                                <input class="image-field" type="file" id="cust_service_image" name="cust_service_image" value="Drag and Drop your image" accept="image/*" onchange="previewImage(this, 'mainImagePreview')" multiple/>
                            <div id="mainImagePreview" class="image-preview"></div>
                            @error('cust_service_image')
                                <div class="error-message" >{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <div  class="input-field">
                            <input type="text" id="comment" name="comment" value="{{ old('comment', $request->comment) }}" />
                        </div>
                        @error('comment')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="#" selected="true" disabled="true">Select the Status</option>
                            <option value="Open" {{ old('status', $request->status) == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="In Progress" {{ old('status', $request->status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Resolved" {{ old('status', $request->status) == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                        @error('status')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

                    <div class="add_user_btn_group">
                        <a href="{{ route('contact.showCustomerServiceList') }} " class="btn btn-danger">Back</a>
                        <button type="submit" class="btn">Edit Request Record</button>
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