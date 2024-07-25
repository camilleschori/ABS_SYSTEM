<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ url('assets/compiled/css/app.rtl.css') }}">
    <link rel="stylesheet" href="{{ url('assets/compiled/css/app-dark.rtl.css') }}">



    <link rel="shortcut icon" href="{{ url('assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ url('assets/compiled/svg/favicon.svg') }}" type="image/png">


    <link rel="stylesheet" href="{{ url('assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ url('assets/compiled/css/auth.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/leaflet.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">


    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/select2.min.js') }}"></script>
    <script src="{{ url('assets/js/leaflet.js') }}"></script>
    <script src="{{ url('assets/js/sweetalert2.js') }}"></script>


</head>

<body class="overflow-hidden">


    <script src="{{ url('assets/static/js/initTheme.js') }}"></script>

    @yield('content')




    <script src="{{ url('assets/static/js/components/dark.js') }}"></script>
    <script src="{{ url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/compiled/js/app.js') }}"></script>

    
    {{-- <script src="{{ url('assets/compiled/js/custom_script.js') }}"></script>
    <script src="{{ url('assets/static/js/pages/dashboard.js') }}"></script> --}}
    {{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                let errorMessages = `
                    <ol>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger list- text-start ">{{ $error }}</li>
                    @endforeach
                    </ol>
                `;
                Swal.fire({
                    title: 'فشل في اكمال العملية',
                    html: errorMessages,
                    icon: 'error'
                });
            @endif
        });
    </script> --}}

    <script>
        // Auto-hide the alert after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $(document).find('.alert').alert('close');
            }, 1000);
        })
        // 5000 milliseconds = 5 seconds
    </script>
    @stack('scripts')
</body>

</html>
