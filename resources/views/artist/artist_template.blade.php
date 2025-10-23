<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
            {{-- Disable Right Click sementara --}}
    <script>
        document.onkeydown = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123 || event.keyCode == 18) {
                return false;
            }
        }
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>

    {{-- icon: font awesome --}}
    <script src="https://kit.fontawesome.com/2773bd903f.js" crossorigin="anonymous"></script>
</head>

<body>
    @include('artist.navbar')

    @yield('content')

    @yield('scripts')
</body>

</html>
