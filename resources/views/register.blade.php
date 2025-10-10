<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
</head>

<body class="flex justify-center items-center h-screen">
    <div
        class="flex flex-col justify-center items-center bg-[#f0ebe3] w-[60%] h-[70%] p-7 rounded-3xl outline outline-4 outline-black">
        {{-- judul --}}
        <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
            <h1 class="text-3xl md:text-5xl lg:text-7xl">Register</h1>
        </div>

        <form class="flex flex-col gap-3" action="" method="post">
            <input class="bg-[#a2e1db] placeholder-[#7dc8c1] placeholder:font-bold rounded-2xl p-3 text-[3vh]" type="" name="" id="" placeholder="Username">
            <input class="bg-[#a2e1db] placeholder-[#7dc8c1] placeholder:font-bold rounded-2xl p-3 text-[3vh]" type="password" name="" id="" placeholder="Password">
            <button type="submit" class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-[50%] rounded outline hover:bg-[#7dc8c1] transition-colors duration-300 ease-in-out">Register</button>
        </form>

        <div class="forgotPassword flex ml-[80vh] mr-[5vh] w-fit ">
            <a href="/login"
                class="flex justify-center text-2xl font-semibold text-[3vh] w-[50vh] p-2 text-black hover:text-[#ffac81] transition">
                Already a member?
            </a>
        </div>
    </div>

    </div>
</body>

</html>
