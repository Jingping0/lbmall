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

    <Script>
        let errorMessage = document.querySelector('.error');

        setTimeout(function(){
            if(errorMessage) {
                errorMessage.remove();
            }
        }, 2000);
    </Script>



    <div class="container">
    
        <form action="{{ route('address.update', $address->address_id) }}" method="POST">
    @csrf
    @method('PUT')

    <h3 class="title">Edit</h3>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">

        <div class="col">

            <div class="inputBox">
                <span>full name :</span>
                <input type="text" value="{{ $address->username }}" placeholder="john Cena" name="username">
                @error('username')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="inputBox">
                <span>Street :</span>
                <input type="text" value="{{ $address->street }}" placeholder="23, Jalan Mamak" name="street">
                @error('street')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="inputBox">
                <span>Post Code :</span>
                <input type="text" value="{{ $address->postcode }}" placeholder="41200" name="postcode">
                @error('postcode')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col">

        <div class="inputBox">
                <span>Phone Number :</span>
                <input type="tel" value="{{ $address->address_userphone }}" placeholder="012-34567890" name="address_userphone" >
                @error('address_userphone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="inputBox">    
                <span for="area">Area</span>
                <select class="area_select" name="area" id="area">
                    <option value="" disabled selected>Select Area</option>
                    <option value="Johor" {{ $address->area === 'Johor' ? 'selected' : '' }}>Johor</option>
                    <option value="Kedah" {{ $address->area === 'Kedah' ? 'selected' : '' }}>Kedah</option>
                    <option value="Kelantan" {{ $address->area === 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                    <option value="Kuala Lumpur" {{ $address->area === 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                    <option value="Melaka" {{ $address->area === 'Melaka' ? 'selected' : '' }}>Melaka</option>
                    <option value="Negeri Sembilan" {{ $address->area === 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                    <option value="Pahang" {{ $address->area === 'Pahang' ? 'selected' : '' }}>Pahang</option>
                    <option value="Perak" {{ $address->area === 'Perak' ? 'selected' : '' }}>Perak</option>
                    <option value="Perlis" {{ $address->area === 'Perlis' ? 'selected' : '' }}>Perlis</option>
                    <option value="Penang" {{ $address->area === 'Penang' ? 'selected' : '' }}>Penang</option>
                    <option value="Selangor" {{ $address->area === 'Selangor' ? 'selected' : '' }}>Selangor</option>
                    <option value="Terengganu" {{ $address->area === 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                    <!-- Add more options as needed -->
                </select>
                @error('area')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

        </div>

    </div>
    <a href="{{ route('address.getCustomerAddress') }}" class="submit-btn btns" type="submit">Back</a>
    <button type="submit" class="submit-btn btns">Update</button>
</form>

        
    </div>    
    
    </body>
    </html>