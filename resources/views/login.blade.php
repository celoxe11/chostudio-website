<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex justify-center items-center h-screen">
    <div
        class="flex flex-col justify-center items-center bg-[#f0ebe3] w-[95%] max-w-5xl min-h-[70%] p-8 rounded-3xl border-4 border-black">
        {{-- judul --}}
        <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
            <h1 class="text-3xl md:text-5xl lg:text-5xl">LOGIN</h1>
        </div>

        <form class="flex flex-col items-center gap-4 w-full max-w-md" action="" method="post">
            @csrf
            <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="text" name="username" id="username" placeholder="Username" required>
            <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full py-4 text-xl rounded-2xl outline hover:bg-[#477c77] transition-colors duration-300 ease-in-out">Login</button>
        </form>

        <div class="flex flex-col items-center gap-3 mt-6">
            <a href="/register"
                class="text-lg font-semibold text-black hover:text-[#ffac81] transition-colors duration-300">
                Don't have an account? Register here
            </a>
        </div>
    </div>
</body>

</html>
