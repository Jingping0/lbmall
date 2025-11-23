<div class="left message">
   <img class="image_icon" src="{{ auth()->user()->role === 'customer' ? 'img/adminProfile.png' : 'img/user.png' }}" alt="Avatar">
    <p>{{$message}}</p>
  </div>