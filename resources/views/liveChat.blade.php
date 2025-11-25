<!DOCTYPE html>
<html lang="en">
<head>
  <title>LB | Live Chat</title>
  <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

  <link rel="stylesheet" href="{{ asset('css/liveChat.css') }}">
</head>

<body>
<div class="chat">

  <!-- Header -->
  <div class="top">
    <img class="image_icon"
         src="{{ auth()->user()->role === 'staff' ? 'img/adminProfile.png' : 'img/user.png' }}"
         alt="Avatar" width="80" height="80">
    <div>
      <p>{{ auth()->user()->name }}</p>
      <small class="user_email">{{ auth()->user()->email }}</small>
      <small class="online_status">Online</small>
    </div>
  </div>

  <!-- Chat Messages -->
  <div id="messages" class="messages">

    @if(auth()->user()->role === 'customer')
        @include('receive', ['message' => "Hi there 👋"])
        @include('receive', ['message' => "Anything I can assist you? 😊"])

    @elseif (auth()->user()->role === 'staff')
        @include('broadcast', ['message' => "Hi there 👋"])
        @include('broadcast', ['message' => "Anything I can assist you? 😊"])
    @endif

  </div>

  <!-- Footer -->
  <div class="bottom">
    <form onsubmit="event.preventDefault(); sendMessage();">
      <input type="hidden" id="user" value="{{ auth()->user()->name }}">
      <input type="text" id="msg" name="message" placeholder="Enter message..." autocomplete="off">
      <button type="submit">Send</button>
    </form>
  </div>

</div>
</body>

<script>
    const pusher = new Pusher("YOUR_PUSHER_KEY", {
        cluster: "ap1"
    });

    const channel = pusher.subscribe('chat-room');

    channel.bind('new-message', function(data) {

        // 判断消息显示左边还是右边（跟角色无关，只要不是自己发的就是左边）
        const currentUser = document.getElementById("user").value;

        let template = '';

        if (data.user === currentUser) {
            template = `
                <div class="message message-right">
                    <div class="bubble">${data.message}</div>
                </div>
            `;
        } else {
            template = `
                <div class="message message-left">
                    <div class="bubble">${data.message}</div>
                </div>
            `;
        }

        document.getElementById("messages").innerHTML += template;

        // 自动滚动到底部
        const container = document.getElementById("messages");
        container.scrollTop = container.scrollHeight;
    });

    function sendMessage() {
    const user = document.getElementById("user").value;
    const message = document.getElementById("msg").value;

    if (message.trim() === "") return;

    fetch("/send-message", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content
        },
        body: JSON.stringify({ user, message })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) console.error(data.error, data.trace);
    });

    // 本地显示右边消息
    document.getElementById("messages").innerHTML += `
        <div class="message message-right">
            <img class="image_icon" src="{{ auth()->user()->role === 'staff' ? '/img/adminProfile.png' : '/img/user.png' }}" alt="Avatar">
            <p class="bubble">${message}</p>
        </div>
    `;

    document.getElementById("msg").value = "";
    const container = document.getElementById("messages");
    container.scrollTop = container.scrollHeight;
}

</script>

</html>
