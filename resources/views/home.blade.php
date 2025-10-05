<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex flex-row items-center h-screen">

    {{-- sidebar --}}
    <div class="flex flex-col items-center h-full bg-[#f0ebe3] w-[25%]">
        <div class="personaImage bg-[#a2e1db] w-[30vh] h-[30vh] m-3">
            OC Brenda
        </div>
        <div class="title w-[70%] h-fit m-3"><a href="/home"
                class="flex items-center h-[12vh] p-2 bg-[#ffac81] rounded-2xl outline outline-3 outline-black 
          shadow-[1vh_1vh_0_black]
          flex justify-center 
          font-[HammersmithOne-Regular] font-bold 
          text-[#f0ebe3] text-[4vh]">
                CHO.LAZEY
            </a></div>
        <div class="link-socials"><a href="http://">instagram</a>, <a href="http://">line</a></div>

        <div class="button-group flex justify-center font-[HammersmithOne-Regular]">
            <ul class="m-3">
                <li class="m-3"> <button
                        class="flex justify-center items-center bg-[#a2e1db] hover:bg-[#b4a6d5] p-3 rounded-2xl w-[30vh]"><a
                            href="http://">Gallery</a></button>
                </li>
                <li class="m-3">
                    <button
                        class="flex justify-center items-center bg-[#a2e1db] hover:bg-[#b4a6d5] p-3 rounded-2xl w-[30vh]"><a
                            href="http://">Commission</a></button>
                </li>
                <li class="m-3">
                    <button
                        class="flex justify-center items-center bg-[#a2e1db] hover:bg-[#b4a6d5] p-3 rounded-2xl w-[30vh]"><a
                            href="http://">Shop</a></button>
                </li>
                <li class="m-3">
                    <button
                        class="flex justify-center items-center bg-[#a2e1db] hover:bg-[#b4a6d5] p-3 rounded-2xl w-[30vh]"><a
                            href="http://">Work Progress</a></button>
                </li>
            </ul>
        </div>

    </div>

    {{-- isi konten halaman --}}
    <div class="content h-full w-full flex items-center justify-center bg-[url('/assets/images/Background.png')] bg-no-repeat bg-cover">
        <div
            class="flex flex-col justify-center items-center bg-[#f0ebe3] w-[80%] h-[80%] p-7 rounded-3xl outline outline-4 outline-black shadow-[3vh_3vh_0_black]">
            bababooey
        </div>
    </div>

</body>

</html>
