<div class="right message">
    <p>{{$message}}</p>
    <img class="image_icon" src="{{ auth()->user()->role === 'staff' ? 'img/adminProfile.png' : 'img/user.png' }}" alt="Profile picture">
  </div>