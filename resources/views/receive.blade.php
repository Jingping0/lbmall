<div class="left message">
   <img class="image_icon"
        src="{{ auth()->user()->role === 'staff' ? 'img/user.png' : 'img/adminProfile.png' }}"
        alt="Avatar">
   <p>{{ $message }}</p>
</div>
