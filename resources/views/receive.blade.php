<div class="left message" data-message-id="{{ $messageId ?? '' }}" data-timestamp="{{ isset($timestamp) ? $timestamp->toIso8601String() : '' }}">
   <img class="image_icon"
        src="{{ isset($user) && $user ? ($user->role === 'staff' ? 'img/adminProfile.png' : 'img/user.png') : 'img/user.png' }}"
        alt="Avatar">
   <div>
     <p>{!! nl2br(e($message)) !!}</p>
     <div class="message-meta">
       @if(isset($user) && $user)
       <small class="message-sender">{{ $user->name }}</small>
       @elseif(isset($fromName))
       <small class="message-sender">{{ $fromName }}</small>
       @endif
       @if(isset($timestamp))
       <small class="message-time" title="{{ $timestamp->format('Y-m-d H:i:s') }}">{{ $timestamp->format('H:i') }}</small>
       @endif
     </div>
   </div>
</div>
