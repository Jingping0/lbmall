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
                <label class="title">Edit Staff</label>
            </div>

            <form method="post">
                @csrf
                @method('PUT')
                <div class="user-details">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input class="input-field" type="text" id="username" name="username" value="{{ old('username', $staff->username) }}"/>
                        @error('username')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div  class="input-field">
                            <input type="password" id="password" name="password" value="{{ old('password', $staff->password) }}"/>
                             <span class="show_button"><i class="icon-show-password fa fa-eye-slash " id="eye" onclick="toggle()"></i><span class="show_passwordText">Show password</span></span>

                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="input-field" type="text" id="name" name="name" value="{{ old('name', $staff->name) }}"/>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="input-field" type="email" id="email" name="email" value="{{ old('email', $staff->email) }}"/>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Position</label>
                        <select class="form-select" id="position" name="position">
                            <option value="#" selected="true" disabled="true">Select the Position</option>
                            <option value="admin" {{ old('position', $staff->position) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('position', $staff->position) == 'staff' ? 'selected' : '' }}>Staff</option>
                            <!-- Add more options as needed -->
                        </select>
                        @error('position')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
                    <div class="add_user_btn_group">
                        <a href="{{ route('admin.showStaffList') }} " class="btn btn-danger">Back</a>
                        <button type="submit" class="btn">Edit Staff</button>
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