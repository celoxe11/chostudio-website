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
        class="flex flex-col justify-center items-center bg-[#f0ebe3] w-[75%] h-[70%] p-7 rounded-3xl outline outline-4 outline-black shadow-[3vh_3vh_0_black]">

        {{-- judul --}}
        <div class="flex justify-center mb-6 font-bold font-[HammersmithOne-Regular] mt-[5vh]">
            <h1 class="text-4xl md:text-6xl lg:text-8xl">CHO'S STUDIO</h1>
        </div>

        {{-- tombol --}}
        <div class="flex flex-row gap-6 justify-center items-center">

            {{-- ke home page --}}
            <a href="/home"
                class="px-8 py-4 bg-[#ffac81] rounded-3xl outline outline-4 outline-black 
          shadow-[1vh_1vh_0_black] 
          transform transition-transform duration-300 
          hover:scale-125 hover:rotate-[-5deg] 
          flex justify-center items-center 
          font-[HammersmithOne-Regular] font-bold 
          text-[#f0ebe3] text-[5vh]">
                Let’s Go
            </a>
        </div>

        {{-- ke login page --}}
        <div class="loginbutton flex mt-[5vh] ml-[110vh] mr-[5vh] w-fit ">
            <a href="/login"
                class="flex justify-center text-2xl font-semibold text-[3vh] w-[20vh]  mt-[5vh]  outline rounded-[10vh] p-2 text-black hover:text-[#ffac81] transition">
                Login
            </a>
        </div>
    </div>
</body>

</html>
