{{-- <!DOCTYPE html>
<html>
<head>
    <title>WebSocket Example</title>

    @vite('resources/js/app.js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

        #messageDisplay {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            width: 300px;
        }
    </style>
</head>
<body>

    <input type="text" id="messageInput" placeholder="Enter your message">
    <button id="sendMessage">Send Message</button>
    <div id="messageDisplay"></div>

    <script type="module">
        document.getElementById('sendMessage').addEventListener('click', function() {
            const message = document.getElementById('messageInput').value;
            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: message }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // For debugging
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        if (window.Echo) {
            Echo.channel('test-channel')
                .listen('.SendMessageToClientEvent', (e) => {
                    console.log('Event received:', e);
                    const messageDiv = document.getElementById('messageDisplay');
                    messageDiv.textContent = e.message; // Update the div content
                });
        } else {
            console.error('Echo is not defined');
        }
    </script>

</body>
</html> --}}



{{-- @extends('admin.layouts.app')
@section('panel')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="module" src="{{ asset('js/app.js') }}"></script>

    <input type="text" id="messageInput" placeholder="Enter your message">
    <button id="sendMessage">Send Message</button>
    <div id="messageDisplay"></div>

    <script type="module">
        document.getElementById('sendMessage').addEventListener('click', function() {
            const message = document.getElementById('messageInput').value;
            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ message: message }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // For debugging
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        if (window.Echo) {

            Echo.channel('test-channel')
                .listen('.SendMessageToClientEvent', (e) => {
                    alert('Hello');
                    console.log('Event received:', e);
                    const messageDiv = document.getElementById('messageDisplay');
                    messageDiv.textContent = e.message;
                });
        } else {
            console.error('Echo is not defined');
        }
    </script>


@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.password') }}" class="btn btn-sm btn-outline--primary"><i class="las la-key"></i>@lang('Password Setting')</a>
@endpush

@push('style-lib')
    <style>
        #messageDisplay {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            width: 300px;
        }
    </style>
@endpush --}}


@extends('admin.layouts.app')
@section('panel')
<meta name="csrf-token" content="{{ csrf_token() }}">

<script type="module" src="{{ asset('js/app.js') }}"></script>

<button id="sendMessage">Send Message</button>
<div id="messageDisplay"></div>

<script type="module">
    document.getElementById('sendMessage').addEventListener('click', function() {
        fetch('/try-websocket');
    });

    if (window.Echo) {


        Echo.channel('test-channel')
            .listen('.SendMessageToClientEvent', (e) => {
                console.log('Event received:', e);
                const messageDiv = document.getElementById('messageDisplay');
                messageDiv.textContent = e.message;
            });
    } else {
        console.error('Echo is not defined');
    }
</script>


@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.password') }}" class="btn btn-sm btn-outline--primary"><i class="las la-key"></i>@lang('Password Setting')</a>
@endpush

@push('style-lib')
    <style>
      #messageDisplay {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            width: 300px;
        }
    </style>
@endpush










