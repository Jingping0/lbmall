<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="{{ asset('css/cus_addAddress.css') }}">

</head>
<body>

<div class="container">

    <form action="{{ route('address.store') }}" method="POST">
        @csrf

        <h3 class="title">Add Address</h3>

        @if ($errors->has('username') || $errors->has('street') || $errors->has('postcode') || $errors->has('address_userphone') || $errors->has('area'))
        <div class="alert alert-danger">
            @if ($errors->has('username'))
                <div class="error">{{ $errors->first('username') }}</div>
            @endif
    
            @if ($errors->has('street') && !$errors->has('username'))
                <div class="error">{{ $errors->first('street') }}</div>
            @endif
    
            @if ($errors->has('postcode') && !$errors->has('username') && !$errors->has('street'))
                <div class="error">{{ $errors->first('postcode') }}</div>
            @endif
    
            @if ($errors->has('address_userphone') && !$errors->has('username') && !$errors->has('street') && !$errors->has('postcode'))
                <div class="error">{{ $errors->first('address_userphone') }}</div>
            @endif
    
            @if ($errors->has('area') && !$errors->has('username') && !$errors->has('street') && !$errors->has('postcode') && !$errors->has('address_userphone'))
                <div class="error">{{ $errors->first('area') }}</div>
            @endif
        </div>
    @endif

        <div class="row">

            <div class="col">

                <div class="inputBox">
                    <span>Address Name</span>
                    <input type="text" placeholder="Home" name="username" value="{{ old('username') }}">
                    
                </div>
                <div class="inputBox">
                    <span>Street</span>
                    <input type="text" placeholder="23, Jalan Mamak" name="street" value="{{ old('street') }}">
                </div>
                <div class="inputBox">
                    <span>Post Code</span>
                    <input type="text" placeholder="41200" name="postcode" value="{{ old('postcode') }}">
                </div>
            </div>

            <div class="col">

            <div class="inputBox">
                    <span>Phone Number</span>
                    <input type="tel" placeholder="011-11222333" name="address_userphone" value="{{ old('address_userphone') }}">
                </div>

                <div class="inputBox">    
                    <span for="area">Area</span>
                    <select class="area_select" name="area" id="area">
                        <option value="" disabled selected>Select Area</option>
                        <option value="Johor" {{ old('area') == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Kedah" {{ old('area') === 'Kedah' ? 'selected' : '' }}>Kedah</option>
                        <option value="Kelantan" {{ old('area') === 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                        <option value="Kuala Lumpur" {{ old('area') === 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Melaka" {{ old('area') === 'Melaka' ? 'selected' : '' }}>Melaka</option>
                        <option value="Negeri Sembilan" {{ old('area') === 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                        <option value="Pahang" {{ old('area') === 'Pahang' ? 'selected' : '' }}>Pahang</option>
                        <option value="Perak" {{ old('area') === 'Perak' ? 'selected' : '' }}>Perak</option>
                        <option value="Perlis" {{ old('area') === 'Perlis' ? 'selected' : '' }}>Perlis</option>
                        <option value="Penang" {{ old('area') === 'Penang' ? 'selected' : '' }}>Penang</option>
                        <option value="Selangor" {{ old('area') === 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Terengganu" {{ old('area') === 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>

            </div>
    
        </div>
            <a href="{{ route('address.getCustomerAddress') }}" class="submit-btn btns" type="submit">Back</a>
            <input type="submit" value="Add" class="submit-btn">
        </form>
</div>    

</body>
</html>