@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-4 mb-30">

            <div class="card b-radius--5 overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-flex bg--primary align-items-center p-3">
                        <div class="avatar avatar--lg">
                            <img style="display: none;" src="{{ getImage(getFilePath('adminProfile') . '/' . $admin->image, getFileSize('adminProfile')) }}" alt="@lang('Image')">
                        </div>
                        <div class="ps-3">
                            <h4 class="text--white">{{ __($admin->name) }}</h4>
                        </div>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="fw-bold">{{ __($admin->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">{{ __($admin->username) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="fw-bold">{{ $admin->email }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-8 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 border-bottom pb-2">@lang('Profile Information')</h5>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">


                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" value="{{ $admin->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email" value="{{ $admin->email }}" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" style="background-color: #2E3192;color: #fff;" class="mt-3 btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.password') }}" class="btn btn-sm btn-outline--primary"><i class="las la-key"></i>@lang('Password Setting')</a>
@endpush

@push('style-lib')
    <style>

    </style>
@endpush




{{-- @extends('admin.layouts.app')
@section('panel')


    <script type="module" src="{{ asset('assets/app.js') }}"></script>


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
