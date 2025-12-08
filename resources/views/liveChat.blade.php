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
    @if(isset($messages) && $messages->count() > 0)
        @foreach($messages as $msg)
            @if($msg->from_id == auth()->user()->user_id)
                @include('broadcast', [
                    'message' => $msg->body, 
                    'user' => $msg->fromUser,
                    'messageId' => $msg->id,
                    'timestamp' => $msg->created_at
                ])
            @else
                @include('receive', [
                    'message' => $msg->body, 
                    'user' => $msg->fromUser,
                    'messageId' => $msg->id,
                    'timestamp' => $msg->created_at
                ])
            @endif
        @endforeach
    @else
        @if(auth()->user()->role === 'customer')
            @include('receive', ['message' => "Hi there 👋", 'user' => null])
            @include('receive', ['message' => "Anything I can assist you? 😊", 'user' => null])
        @elseif (auth()->user()->role === 'staff')
            @include('broadcast', ['message' => "Hi there 👋", 'user' => auth()->user()])
            @include('broadcast', ['message' => "Anything I can assist you? 😊", 'user' => auth()->user()])
        @endif
    @endif
  </div>
  <!-- End Chat -->

  <!-- Footer -->
  <div class="bottom">
    <form id="chatForm">
      <input type="text" id="message" name="message" placeholder="Enter message... (Press Enter to send)" autocomplete="off" maxlength="5000">
      <button type="submit" id="sendButton" title="Send message">
        <span id="sendIcon">✈</span>
        <span id="sendingSpinner" style="display:none;">⏳</span>
      </button>
    </form>
    <div id="errorMessage" style="display:none; color:red; font-size:12px; margin-top:5px;"></div>
  </div>
  <!-- End Footer -->
  
  <!-- Load More Button -->
  <div style="text-align:center; padding:10px;">
    <button id="loadMoreBtn" style="display:none; padding:8px 16px; background:#007bff; color:white; border:none; border-radius:4px; cursor:pointer;">
      Load More Messages
    </button>
  </div>

</div>
</body>

<script>
(function() {
  'use strict';
  
  // Configuration
  const CONFIG = {
    currentUserId: {{ auth()->user()->user_id }},
    csrfToken: '{{csrf_token()}}',
    pusherKey: "{{ config('broadcasting.connections.pusher.key') }}",
    pusherCluster: "{{ config('broadcasting.connections.pusher.options.cluster', 'ap1') }}",
    enableSound: true,
    autoScrollThreshold: 100, // pixels from bottom to auto-scroll
    debounceDelay: 300,
    throttleDelay: 1000
  };

  // State
  const state = {
    displayedMessageIds: new Set(),
    isLoading: false,
    isSending: false,
    isPolling: false, // Track if polling request is in progress
    oldestMessageId: null,
    hasMoreMessages: true,
    pusher: null,
    channel: null,
    audioContext: null,
    connectionStatus: 'disconnected', // 'connected', 'disconnected', 'connecting', 'failed'
    usePolling: false
  };

  // Utility Functions
  const utils = {
    // Debounce function
    debounce: function(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    },

    // Throttle function
    throttle: function(func, limit) {
      let inThrottle;
      return function(...args) {
        if (!inThrottle) {
          func.apply(this, args);
          inThrottle = true;
          setTimeout(() => inThrottle = false, limit);
        }
      };
    },

    // Play notification sound
    playSound: function() {
      if (!CONFIG.enableSound || !state.audioContext) return;
      try {
        const oscillator = state.audioContext.createOscillator();
        const gainNode = state.audioContext.createGain();
        oscillator.connect(gainNode);
        gainNode.connect(state.audioContext.destination);
        oscillator.frequency.value = 800;
        oscillator.type = 'sine';
        gainNode.gain.setValueAtTime(0.1, state.audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, state.audioContext.currentTime + 0.1);
        oscillator.start(state.audioContext.currentTime);
        oscillator.stop(state.audioContext.currentTime + 0.1);
      } catch (e) {
        console.warn('Could not play sound:', e);
      }
    },

    // Smooth scroll to bottom
    scrollToBottom: function(force = false) {
      const messagesContainer = $('.messages');
      if (messagesContainer.length === 0) {
        console.warn('Messages container not found for scrolling');
        return;
      }
      
      const scrollHeight = messagesContainer[0].scrollHeight;
      const scrollTop = messagesContainer.scrollTop();
      const clientHeight = messagesContainer[0].clientHeight;
      const distanceFromBottom = scrollHeight - scrollTop - clientHeight;

      if (force || distanceFromBottom < CONFIG.autoScrollThreshold) {
        // Multiple scroll methods to ensure it works
        // Method 1: jQuery animate
        $('html, body').animate({
          scrollTop: $(document).height()
        }, 300);
        
        // Method 2: Direct scroll on messages container
        messagesContainer[0].scrollTop = messagesContainer[0].scrollHeight;
        
        // Method 3: Window scroll
        window.scrollTo({
          top: document.body.scrollHeight,
          behavior: 'smooth'
        });
      }
    },

    // Show error message
    showError: function(message) {
      const $errorDiv = $('#errorMessage');
      $errorDiv.text(message).fadeIn();
      setTimeout(() => $errorDiv.fadeOut(), 5000);
    },

    // Format timestamp
    formatTime: function(timestamp) {
      if (!timestamp) return '';
      const date = new Date(timestamp);
      const now = new Date();
      const diff = now - date;
      const minutes = Math.floor(diff / 60000);
      
      if (minutes < 1) return 'Just now';
      if (minutes < 60) return minutes + 'm ago';
      if (date.toDateString() === now.toDateString()) {
        return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      }
      return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }
  };

  // Initialize Pusher with improved error handling
  function initPusher() {
    if (!CONFIG.pusherKey) {
      console.error('Pusher key is not configured');
      utils.showError('Real-time chat is not available. Using polling mode.');
      startPolling();
      return;
    }

    @if(config('app.debug'))
      Pusher.logToConsole = true;
    @else
      Pusher.logToConsole = false;
    @endif

    try {
      state.pusher = new Pusher(CONFIG.pusherKey, {
        cluster: CONFIG.pusherCluster,
        forceTLS: true,
        enabledTransports: ['ws', 'wss', 'xhr_streaming', 'xhr_polling'],
        enableStats: false, // Use enableStats instead of deprecated disableStats
        authEndpoint: null,
        auth: {
          headers: {}
        }
      });

      state.channel = state.pusher.subscribe('public');

      // Connection state handlers
      state.pusher.connection.bind('state_change', (states) => {
        console.log('Pusher state:', states.previous, '->', states.current);
        state.connectionStatus = states.current;
        
        if (states.current === 'connected') {
          $('#errorMessage').fadeOut();
          state.usePolling = false;
          stopPolling(); // Stop polling if Pusher connects
        } else if (states.current === 'failed' || states.current === 'disconnected') {
          if (states.current === 'failed') {
            console.warn('Pusher connection failed, falling back to polling');
            state.usePolling = true;
            // Start polling immediately when Pusher fails
            setTimeout(() => {
              if (!pollingInterval) {
                startPolling();
              }
            }, 1000); // Wait 1 second before starting polling
          } else if (states.current === 'disconnected') {
            // If disconnected, also start polling as backup
            if (!pollingInterval && state.connectionStatus !== 'connected') {
              setTimeout(() => {
                if (!pollingInterval) {
                  startPolling();
                }
              }, 2000);
            }
          }
        } else if (states.current === 'connecting') {
          state.connectionStatus = 'connecting';
        }
      });

      state.pusher.connection.bind('error', (err) => {
        console.error('Pusher connection error:', err);
        if (err.error && err.error.code === 1006) {
          utils.showError('Connection lost. Using polling mode...');
          startPolling();
        } else {
          utils.showError('Connection error. Trying to reconnect...');
        }
      });

      state.pusher.connection.bind('connected', () => {
        console.log('Pusher connected successfully');
        $('#errorMessage').fadeOut();
        stopPolling();
      });

      state.pusher.connection.bind('disconnected', () => {
        console.warn('Pusher disconnected');
        utils.showError('Disconnected. Reconnecting...');
      });

      state.pusher.connection.bind('unavailable', () => {
        console.warn('Pusher unavailable, using polling');
        utils.showError('Real-time unavailable. Using polling mode...');
        startPolling();
      });

      // Message receiver
      state.channel.bind('chat', handleIncomingMessage);
      
      // Channel subscription handlers
      state.channel.bind('pusher:subscription_succeeded', () => {
        console.log('Subscribed to public channel');
      });

      state.channel.bind('pusher:subscription_error', (err) => {
        console.error('Subscription error:', err);
        utils.showError('Subscription failed. Using polling mode...');
        startPolling();
      });

    } catch (error) {
      console.error('Failed to initialize Pusher:', error);
      utils.showError('Failed to initialize real-time. Using polling mode...');
      startPolling();
    }
  }

  // Polling fallback mechanism
  let pollingInterval = null;
  let lastMessageId = null;

  function startPolling() {
    if (pollingInterval) {
      console.log('Polling already active');
      return; // Already polling
    }
    
    state.usePolling = true;
    console.log('Starting polling mode for receiving messages');
    utils.showError('实时连接不可用。使用轮询模式检查新消息（每3秒）...');
    
    // Check immediately
    checkForNewMessages();
    
    // Then poll every 3 seconds (more frequent for better UX)
    pollingInterval = setInterval(() => {
      // Only poll if page is visible (save resources when tab is hidden)
      if (!document.hidden) {
        checkForNewMessages();
      }
    }, 3000);
    
    // Also listen for page visibility changes
    document.addEventListener('visibilitychange', function() {
      if (!document.hidden && pollingInterval) {
        // When page becomes visible, check immediately
        checkForNewMessages();
      }
    });
  }

  function stopPolling() {
    if (pollingInterval) {
      clearInterval(pollingInterval);
      pollingInterval = null;
      state.usePolling = false;
      console.log('Stopped polling mode');
      $('#errorMessage').fadeOut();
    }
  }

  function checkForNewMessages() {
    // Prevent multiple simultaneous requests
    if (state.isPolling) {
      return;
    }
    
    state.isPolling = true;
    
    // Get the latest message ID we have
    const latestMsg = $('.messages .message[data-message-id]').last();
    const latestId = latestMsg.length > 0 ? latestMsg.attr('data-message-id') : null;
    
    @if(config('app.debug'))
    console.log('Polling for new messages. Latest ID:', latestId, 'Last checked:', lastMessageId);
    @endif
    
    $.get("/chat/history", {
      limit: 50, // Get more messages to catch up
      after_id: latestId || null
    })
    .done(function(data) {
      if (data.messages && data.messages.length > 0) {
        let hasNew = false;
        let newMessagesCount = 0;
        
        // Process messages in order
        data.messages.forEach(function(msg) {
          if (!state.displayedMessageIds.has(msg.id)) {
            hasNew = true;
            newMessagesCount++;
            
            // Determine if it's own message or from others
            const isOwnMessage = msg.from_id === CONFIG.currentUserId;
            
            // Fetch message HTML from server
            $.post("/receive", {
              _token: CONFIG.csrfToken,
              message_id: msg.id
            })
            .done(function(res) {
              try {
                // Parse response
                const htmlResponse = typeof res === 'string' ? res : res.toString().trim();
                let $newMessage = $(htmlResponse);
                
                // If parsing failed, try alternative method
                if ($newMessage.length === 0) {
                  const $temp = $('<div>').html(htmlResponse);
                  $newMessage = $temp.find('.message').first() || $temp.find('[data-message-id]').first();
                }
                
                const msgId = $newMessage.attr('data-message-id');
                if (msgId && !state.displayedMessageIds.has(msgId)) {
                  state.displayedMessageIds.add(msgId);
                  
                  // Find messages container
                  let $messagesContainer = $(".chat .messages");
                  if ($messagesContainer.length === 0) {
                    $messagesContainer = $(".messages");
                  }
                  
                  if ($messagesContainer.length > 0) {
                    // Use native DOM for reliability
                    const containerEl = $messagesContainer[0];
                    const messageEl = $newMessage[0];
                    if (containerEl && messageEl) {
                      containerEl.appendChild(messageEl);
                      messageEl.style.display = '';
                      messageEl.style.visibility = 'visible';
                    } else {
                      $messagesContainer.append($newMessage);
                    }
                    
                    utils.scrollToBottom();
                    
                    // Only play sound for messages from others
                    if (!isOwnMessage) {
                      utils.playSound();
                    }
                    
                    // Update lastMessageId
                    lastMessageId = msgId;
                    
                    @if(config('app.debug'))
                    console.log('New message received via polling:', msgId);
                    @endif
                  }
                }
              } catch (error) {
                console.error('Error processing polled message:', error);
              }
            })
            .fail(function(xhr) {
              console.error('Error fetching message HTML:', xhr.responseText);
            });
          }
        });
        
        if (hasNew) {
          @if(config('app.debug'))
          console.log('Found', newMessagesCount, 'new messages via polling');
          @endif
          
          // Update lastMessageId to the latest
          if (data.messages.length > 0) {
            lastMessageId = data.messages[data.messages.length - 1].id;
          }
        } else {
          @if(config('app.debug'))
          console.log('No new messages found');
          @endif
        }
      } else {
        @if(config('app.debug'))
        console.log('No messages returned from server');
        @endif
      }
    })
    .fail(function(xhr) {
      console.error('Polling error:', xhr.responseText);
      if (xhr.status === 500) {
        utils.showError('检查新消息时出错');
      }
    })
    .always(function() {
      state.isPolling = false;
    });
  }

  // Handle incoming messages
  function handleIncomingMessage(data) {
    if (data.from_id === CONFIG.currentUserId) return;
    if (data.message_id && state.displayedMessageIds.has(data.message_id)) return;

    $.post("/receive", {
      _token: CONFIG.csrfToken,
      message: data.message,
      from_id: data.from_id,
      from_name: data.from_name,
      from_role: data.from_role,
      message_id: data.message_id,
    })
    .done(function(res) {
      // Parse response
      const htmlResponse = typeof res === 'string' ? res : res.toString();
      const $newMessage = $(htmlResponse.trim());
      const msgId = $newMessage.attr('data-message-id');
      
      if (msgId && !state.displayedMessageIds.has(msgId)) {
        state.displayedMessageIds.add(msgId);
        const $messagesContainer = $(".messages");
        if ($messagesContainer.length > 0) {
          $messagesContainer.append($newMessage);
          utils.scrollToBottom();
          utils.playSound();
          // Update lastMessageId for polling
          lastMessageId = msgId;
        } else {
          console.error('Messages container not found when receiving message');
        }
      }
    })
    .fail(function(xhr) {
      console.error('Error receiving message:', xhr.responseText);
    });
  }

  // Send message
  function sendMessage(messageText) {
    if (state.isSending || !messageText.trim()) return;

    state.isSending = true;
    const $sendButton = $('#sendButton');
    const $sendIcon = $('#sendIcon');
    const $spinner = $('#sendingSpinner');
    
    $sendIcon.hide();
    $spinner.show();
    $sendButton.prop('disabled', true);

    $.ajax({
      url: "/broadcast",
      method: 'POST',
      headers: {
        'X-Socket-Id': state.pusher?.connection?.socket_id || ''
      },
      data: {
        _token: CONFIG.csrfToken,
        message: messageText,
      }
    })
    .done(function(res) {
      try {
        // Parse the HTML response
        let htmlResponse = res;
        if (typeof res !== 'string') {
          htmlResponse = res.toString();
        }
        
        // Trim whitespace
        htmlResponse = htmlResponse.trim();
        
        // Debug log
        @if(config('app.debug'))
        console.log('Received message HTML:', htmlResponse.substring(0, 150));
        @endif
        
        // Parse with jQuery - try multiple methods
        let $newMessage;
        
        // Method 1: Try to find .message class in the HTML
        const $tempDiv = $('<div>').html(htmlResponse);
        $newMessage = $tempDiv.find('.message').first();
        
        // Method 2: If that didn't work, try parsing the whole response directly
        if ($newMessage.length === 0) {
          $newMessage = $(htmlResponse);
        }
        
        // Method 3: If still nothing, try finding any div with data-message-id
        if ($newMessage.length === 0) {
          $newMessage = $tempDiv.find('[data-message-id]').first();
        }
        
        if ($newMessage.length === 0) {
          console.error('Could not parse message HTML. Response:', htmlResponse.substring(0, 100));
          utils.showError('Failed to display message. Please refresh the page.');
          return;
        }
        
        const msgId = $newMessage.attr('data-message-id');
        
        // Find messages container - be very specific
        let $messagesContainer = $(".chat .messages");
        if ($messagesContainer.length === 0) {
          $messagesContainer = $(".messages");
        }
        if ($messagesContainer.length === 0) {
          $messagesContainer = $("div.messages");
        }
        
        if ($messagesContainer.length === 0) {
          console.error('Messages container (.messages) not found in DOM!');
          console.error('Available containers:', $('div').map(function() { return $(this).attr('class'); }).get());
          utils.showError('Chat container not found. Please refresh.');
          return;
        }
        
        // If multiple containers found, use the first one
        if ($messagesContainer.length > 1) {
          console.warn('Multiple .messages containers found, using the first one');
          $messagesContainer = $messagesContainer.first();
        }
        
        @if(config('app.debug'))
        console.log('Using messages container:', $messagesContainer.attr('class'), 'Children count:', $messagesContainer.children().length);
        @endif
        
        // Always add message immediately (sender sees it right away)
        // This works even if Pusher is completely broken
        if (msgId) {
          if (state.displayedMessageIds.has(msgId)) {
            console.log('Message already displayed, skipping:', msgId);
            // Even if already displayed, ensure it's visible
            const $existing = $messagesContainer.find('[data-message-id="' + msgId + '"]');
            if ($existing.length > 0) {
              $existing.show(); // Make sure it's visible
            }
          } else {
            state.displayedMessageIds.add(msgId);
            
            // Add message to container - use native DOM for reliability
            const containerEl = $messagesContainer[0];
            if (containerEl) {
              // Use native appendChild for maximum compatibility
              const messageEl = $newMessage[0];
              if (messageEl) {
                containerEl.appendChild(messageEl);
                
                // Force visibility with inline styles
                messageEl.style.display = '';
                messageEl.style.visibility = 'visible';
                messageEl.style.opacity = '1';
                
                @if(config('app.debug'))
                console.log('Message added using native DOM:', msgId);
                console.log('Container now has', containerEl.children.length, 'children');
                @endif
              } else {
                // Fallback to jQuery
                $messagesContainer.append($newMessage);
                $newMessage.show();
              }
            } else {
              // Fallback to jQuery
              $messagesContainer.append($newMessage);
              $newMessage.show();
            }
            
            // Update tracking variables
            if (!state.oldestMessageId) {
              state.oldestMessageId = msgId;
            }
            lastMessageId = msgId;
            
            @if(config('app.debug'))
            console.log('Message added to DOM:', msgId, 'Container length:', $messagesContainer.children().length);
            @endif
            
            // Verify message is actually in DOM and visible
            setTimeout(() => {
              const $verify = $messagesContainer.find('[data-message-id="' + msgId + '"]');
              if ($verify.length === 0) {
                console.error('CRITICAL: Message was added but not found in DOM!');
                console.error('Attempting to re-add...');
                // Try adding again with a fresh clone
                const $cloned = $newMessage.clone();
                $messagesContainer.append($cloned);
                $cloned.show().css({
                  'display': '',
                  'visibility': 'visible',
                  'opacity': '1'
                });
              } else {
                // Ensure it's visible
                $verify.show().css({
                  'display': '',
                  'visibility': 'visible',
                  'opacity': '1'
                });
                
                @if(config('app.debug'))
                console.log('Message verified in DOM and made visible');
                console.log('Message position:', $verify.position());
                console.log('Message is visible:', $verify.is(':visible'));
                @endif
              }
            }, 50);
          }
        } else {
          // Fallback: add without ID check
          console.warn('Adding message without ID');
          $messagesContainer.append($newMessage);
          $newMessage.show();
        }
        
        // Clear input
        $('#message').val('');
        
        // Focus input for next message
        setTimeout(() => {
          $('#message').focus();
        }, 100);
        
        // Scroll to bottom - multiple methods to ensure it works
        setTimeout(() => {
          // Method 1: Custom scroll function
          utils.scrollToBottom(true);
          
          // Method 2: Direct scroll on messages container
          const messagesEl = $messagesContainer[0];
          if (messagesEl) {
            messagesEl.scrollTop = messagesEl.scrollHeight;
          }
          
          // Method 3: Window scroll
          window.scrollTo({
            top: document.body.scrollHeight,
            behavior: 'smooth'
          });
          
          // Method 4: Force scroll after a short delay
          setTimeout(() => {
            if (messagesEl) {
              messagesEl.scrollTop = messagesEl.scrollHeight;
            }
            window.scrollTo(0, document.body.scrollHeight);
          }, 200);
          
          @if(config('app.debug'))
          console.log('Scrolled to bottom. Container scrollHeight:', messagesEl ? messagesEl.scrollHeight : 'N/A');
          @endif
        }, 100);
        
        // Final verification after a longer delay
        setTimeout(() => {
          const $check = $messagesContainer.find('[data-message-id="' + msgId + '"]');
          if ($check.length > 0) {
            // Ensure it's visible with multiple methods
            $check.show();
            $check.css({
              'display': '',
              'visibility': 'visible',
              'opacity': '1',
              'height': 'auto',
              'overflow': 'visible'
            });
            
            // Check computed styles
            const computedStyle = window.getComputedStyle($check[0]);
            const isVisible = computedStyle.display !== 'none' && 
                            computedStyle.visibility !== 'hidden' && 
                            computedStyle.opacity !== '0';
            
            @if(config('app.debug'))
            console.log('Message confirmed visible in DOM');
            console.log('Computed display:', computedStyle.display);
            console.log('Computed visibility:', computedStyle.visibility);
            console.log('Computed opacity:', computedStyle.opacity);
            console.log('Is visible:', isVisible);
            @endif
            
            if (!isVisible) {
              console.warn('Message exists but computed styles show it as hidden!');
              // Force show with important
              $check[0].style.setProperty('display', 'block', 'important');
              $check[0].style.setProperty('visibility', 'visible', 'important');
              $check[0].style.setProperty('opacity', '1', 'important');
            }
          } else {
            console.error('CRITICAL: Message not found in DOM after 500ms!');
            console.error('Container HTML:', $messagesContainer.html().substring(0, 500));
            utils.showError('消息已发送但未显示。请刷新页面查看。');
          }
        }, 500);
        
      } catch (error) {
        console.error('Error in sendMessage done handler:', error);
        utils.showError('Error displaying message: ' + error.message);
      }
    })
    .fail(function(xhr) {
      const errorMsg = xhr.responseJSON?.error || 'Failed to send message';
      utils.showError(errorMsg);
      console.error('Error sending message:', xhr.responseText);
    })
    .always(function() {
      state.isSending = false;
      $sendIcon.show();
      $spinner.hide();
      $sendButton.prop('disabled', false);
    });
  }

  // Load more messages
  function loadMoreMessages() {
    if (state.isLoading || !state.hasMoreMessages) return;

    state.isLoading = true;
    $('#loadMoreBtn').prop('disabled', true).text('Loading...');

    $.get("/chat/history", {
      limit: 50,
      before_id: state.oldestMessageId
    })
    .done(function(data) {
      if (data.messages && data.messages.length > 0) {
        const scrollHeight = $('.messages')[0].scrollHeight;
        
        data.messages.forEach(function(msg) {
          if (!state.displayedMessageIds.has(msg.id)) {
            // Create message element (simplified - you may need to adjust)
            const isOwn = msg.from_id === CONFIG.currentUserId;
            const template = isOwn ? 'broadcast' : 'receive';
            // Note: This would need server-side rendering or template compilation
            // For now, we'll skip adding old messages via AJAX
            state.displayedMessageIds.add(msg.id);
          }
        });

        state.hasMoreMessages = data.has_more;
        if (data.messages.length > 0) {
          state.oldestMessageId = data.messages[0].id;
        }

        // Restore scroll position
        const newScrollHeight = $('.messages')[0].scrollHeight;
        $('.messages').scrollTop(newScrollHeight - scrollHeight);
      } else {
        state.hasMoreMessages = false;
        $('#loadMoreBtn').hide();
      }
    })
    .fail(function(xhr) {
      console.error('Error loading messages:', xhr.responseText);
      utils.showError('Failed to load more messages');
    })
    .always(function() {
      state.isLoading = false;
      $('#loadMoreBtn').prop('disabled', false).text('Load More Messages');
    });
  }

  // Initialize on page load
  $(document).ready(function() {
    // Initialize message tracking
    $('.messages .message[data-message-id]').each(function() {
      const msgId = $(this).attr('data-message-id');
      if (msgId) {
        state.displayedMessageIds.add(msgId);
        if (!state.oldestMessageId) {
          state.oldestMessageId = msgId;
        }
        // Set lastMessageId for polling
        lastMessageId = msgId;
      }
    });

    // Initialize audio context for notifications
    try {
      state.audioContext = new (window.AudioContext || window.webkitAudioContext)();
    } catch (e) {
      console.warn('Audio context not supported');
    }

    // Initialize Pusher
    initPusher();
    
    // Start polling as backup if Pusher fails to connect within 5 seconds
    setTimeout(() => {
      if (state.connectionStatus !== 'connected' && !pollingInterval) {
        console.log('Pusher did not connect within 5 seconds, starting polling as backup');
        startPolling();
      }
    }, 5000);

    // Auto-focus input
    $('#message').focus();

    // Form submission with debounce
    const debouncedSend = utils.debounce(function() {
      const messageText = $('#message').val().trim();
      if (messageText) {
        sendMessage(messageText);
      }
    }, CONFIG.debounceDelay);

    $('#chatForm').on('submit', function(e) {
      e.preventDefault();
      debouncedSend();
    });

    // Enter key to send (Shift+Enter for new line)
    $('#message').on('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        debouncedSend();
      }
    });

    // Load more button
    $('#loadMoreBtn').on('click', loadMoreMessages);
    if (state.hasMoreMessages && $('.messages .message').length >= 50) {
      $('#loadMoreBtn').show();
    }

    // Auto-scroll on load
    utils.scrollToBottom(true);

    // Throttled scroll handler to show/hide load more button
    $(window).on('scroll', utils.throttle(function() {
      if ($(window).scrollTop() < 100 && state.hasMoreMessages) {
        $('#loadMoreBtn').show();
      }
    }, CONFIG.throttleDelay));
  });
})();
</script>
</html>