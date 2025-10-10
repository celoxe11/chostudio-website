<!DOCTYPE html>
<html lang="en">
{{-- INI HALAMAN GALLERY --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .folder {
            margin-left: 20vh;
            margin-top: 10vh;
        }

        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="h-screen">

    <div class="navbar absolute flex flex-row ml-[50%] mt-[0.5vh]">
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1.5rem]">
            Home
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1.5rem]">
            Gallery
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1.5rem]">
            Shop
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1.5rem]">
            Commission
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1.5rem]">
            Are you a member yet?
        </button>
    </div>

    {{-- isi konten halaman --}}
    <div class="folder block flex-row bg-black rounded-3xl w-[30%] h-[20%]"></div>

    <div
        class="fixed flex flex-col justify-center items-center bg-[#f0ebe3] rounded-3xl w-[29.5%] h-[19.5%] ml-[20.5vh] mt-[-19.5vh]">
        <h1 class="text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular]">Cho's Studio</h1>
        <ul class="flex flex-row font-[HammersmithOne-Regular] text-[1rem] gap-4 m-4">
            <li>Illustrator / Artist</li>
            <li>Graphic Designer</li>
            <li>Original Fanmerch</li>
        </ul>
    </div>

    <div
        class="folder flex justify-center flex-col bg-[#f0ebe3] w-[80%] h-[80%] mt-[-5%] p-10 rounded-3xl outline outline-4 outline-black shadow-[3vh_3vh_0_black]">
        {{-- gallery pictures --}}
        <div class="grid grid-cols-4 gap-4 flex-grow mt-8">
            <div
                class="col-span-2 row-span-2 bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
            </div>
            <div
                class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
            </div>
            <div
                class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
            </div>
            <div
                class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
            </div>
            <div
                class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
            </div>
        </div>
    </div>

</body>

</html>
