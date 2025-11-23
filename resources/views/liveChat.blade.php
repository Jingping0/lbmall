<!DOCTYPE html>
<html lang="en">
<head>
  <title>YEEKIA | Live Chat</title>
  <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- JavaScript -->
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- End JavaScript -->

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/liveChat.css') }}">
  <!-- End CSS -->

</head>

<body>
<div class="chat">

  <!-- Header -->
  <div class="top">
    <img class="image_icon" src="{{ auth()->user()->role === 'staff' ? 'img/adminProfile.png' : 'img/user.png' }}" alt="Avatar" width="80" height="80">
    <div style="">
      <p>{{ auth()->user()->name }}</p>
      <small class="user_email">{{ auth()->user()->email }}</small>
      <small class="online_status">Online</small>
    </div>
  </div>
  <!-- End Header -->

  <!-- Chat -->
  
  <div class="messages">
    @if(auth()->user()->role === 'customer')
        @include('receive', ['message' => "Hi there 👋"])
        @include('receive', ['message' => "Anything I can assist you? 😊"])

    @elseif (auth()->user()->role === 'staff')
        @include('broadcast', ['message' => "Hi there 👋"])
        @include('broadcast', ['message' => "Anything I can assist you? 😊"])
    @endif
  </div>
  <!-- End Chat -->

  <!-- Footer -->
  <div class="bottom">
    <form>
      <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
      <button type="submit"></button>
    </form>
  </div>
  <!-- End Footer -->

</div>
</body>

<script>
  const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap1'});
  const channel = pusher.subscribe('public');

  //Receive messages
  channel.bind('chat', function (data) {
    $.post("/receive", {
      _token:  '{{csrf_token()}}',
      message: data.message,
    })
     .done(function (res) {
       $(".messages > .message").last().after(res);
       $(document).scrollTop($(document).height());
     });
  });

  //Broadcast messages
  $("form").submit(function (event) {
    event.preventDefault();

    $.ajax({
      url:     "/broadcast",
      method:  'POST',
      headers: {
        'X-Socket-Id': pusher.connection.socket_id
      },
      data:    {
        _token:  '{{csrf_token()}}',
        message: $("form #message").val(),
      }
    }).done(function (res) {
      $(".messages > .message").last().after(res);
      $("form #message").val('');
      $(document).scrollTop($(document).height());
    });
  });

</script>
</html>