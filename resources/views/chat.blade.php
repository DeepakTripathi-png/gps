<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel WebSockets Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        #messages {
            list-style-type: none;
            padding: 0;
            margin-bottom: 20px;
        }
        #messages li {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        #message {
            width: 70%;
            padding: 10px;
        }
        button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Chat Application</h1>
    <ul id="messages"></ul>
    <input type="text" id="message" placeholder="Type a message">
    <button onclick="sendMessage()">Send</button>

    <script>
        function sendMessage() {
            const message = document.getElementById('message').value;

            if (message.trim() === '') {
                alert('Please enter a message.');
                return;
            }

            $.ajax({
                url: 'http://127.0.0.1:8000/admin/send-message',
                type: 'POST',
                data: { message: message },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    document.getElementById('message').value = ''; // Clear input field
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        const pusher = new Pusher('04d27283f0a7f3aa8a5a', {
            cluster: 'ap2',
            encrypted: true
        });

        const channel = pusher.subscribe('chat');
        channel.bind('MessageSent', function(data) {
            // Append new message to the messages list
            const messageItem = document.createElement('li');
            messageItem.textContent = data.message;
            document.getElementById('messages').appendChild(messageItem);
        });
    </script>
</body>
</html>

