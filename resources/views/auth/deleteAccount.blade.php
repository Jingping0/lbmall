<!DOCTYPE html>
<html>
    @include('layout.subNav')
</head>
<style>
    .text-danger{
        color: red;
    }
</style>
<body>
    <div class="container_root">

        <div class="grid_title">
            <h1>Delete account</h1>
        </div>
        <div class="grid_content">
            <p>Time to say goodbye? We miss you already! The following happens when you delete your account:</p>
            <p>You delete all personal information and your shopping lists. You will no longer have access to your IKEA Family membership or be able to enjoy the benefits. For tax and other legal reasons, we will keep your purchase history.</p>
            <p>Remember that you are always welcome back!.</p>
            <h2>Any questions?</h2>
            <p>Contact <a href="{{ route('contact') }}">customer service</a></p>
            <div class="line"></div>
            <h3>Password</h3>
            <p>Confirm with your password to continue and delete your account.</p>
            <form action="{{ route('deleteAccount.post',  ['id' => Auth::id()]) }}" method="post">
                @csrf
                <input type="text" class="username">
                <div>
                    <div>
                        <div class="div_input_field">
                            <label for="password">Password</label>
                            <div class="input_field">
                                <input type="password" id="password" name="password" required>
                                <span class="show_button"><i class="icon fa fa-eye-slash " id="eye" onclick="toggle()"></i><span class="show_passwordText">Show password</span></span>
                            </div>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror      
                        </div> 
                    </div>          
                </div>
                <button type="submit" class="submit_button">Delete Account</button>
            </form>
        </div>    
    </div>
    

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

<!-------FOOTER--------->

@include('layout.footer')


</body>
</html>