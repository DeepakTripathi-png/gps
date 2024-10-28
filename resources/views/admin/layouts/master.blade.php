<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>
    <link href="{{ asset("/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/metismenu/css/metisMenu.min.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/simplebar/css/simplebar.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/input-tags/css/tagsinput.css") }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
	{{-- <link href="{{ asset("/assets/css/pace.min.css") }}" rel="stylesheet">
    <script src="{{ asset("/assets/js/pace.min.js") }}"></script> --}}

    <link href="{{ asset("/assets/css/bootstrap.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/assets/bootstrap-icons%401.10.3/font/bootstrap-icons.css") }}">
    <link rel="stylesheet" href="{{ asset("/assets/css/icons.css") }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
    <link href="{{ asset("/assets/css/main.css") }}" rel="stylesheet">
    <link href="{{ asset("/assets/plugins/datatable/css/dataTables.bootstrap5.min.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('style-lib')
</head>

<body>
    @yield('content')
    <script src="{{ asset("/assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/metismenu/js/metisMenu.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/simplebar/js/simplebar.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/input-tags/js/tagsinput.js") }}"></script>
    <script src="{{ asset("/assets/plugins/validation/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("/assets/plugins/validation/validation-script.js") }}"></script>
    <script src="{{ asset("/assets/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("/assets/js/main.js") }}"></script>
    <script src="{{ asset("/assets/js/notification.js") }}"></script>
    <script src="{{ asset('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    @include('admin.partials.alert-notification')

    @include('admin.partials.notify')
  
    @stack('script-lib')    
    @stack('script')
    @stack('style')
   <style>
    #event_notify thead tr {
            display: none;
    }
    #event_notify_filter{
        display: none;
    }
    .ps-alert .swal2-content {
        font-size: 15px!important;
        text-align: left!important;
        padding: 0;
    }
    .ps-alert .swal2-title {
        margin-bottom: 1rem;
        font-size:18px
    }
    .ps-alert .swal2-icon {
        width: 2em;
        height: 2em;
        margin: 0 0 10px 0;
    }
    .ps-alert  .modal-dialog {
        font-size: 12px;
    }
    .ps-alert .swal2-header {
        padding: 0;
    }
    .ps-alert .swal2-actions {
        margin: 0;
    }
    .ps-alert .swal2-styled.swal2-confirm {
        padding: 0.325em 1em;
    }
    #event_notify  tbody tr:first-child td {
        border: none;
    }
</style>

<audio id="alertAudio">
    <source src="{{ asset('/assets/alarm1.mp3')}}" type="audio/mpeg">
</audio>
</body>
</html>
