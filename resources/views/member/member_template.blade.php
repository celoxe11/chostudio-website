<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cho's Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- icon: font awesome --}}
    <script src="https://kit.fontawesome.com/2773bd903f.js" crossorigin="anonymous"></script>
    
    {{-- Flowbite JS for drawer/modal components --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>

<body>
    @include('member.navbar')

    @yield('content')

    @yield('scripts')
</body>
</html>
