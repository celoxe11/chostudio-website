<!DOCTYPE html>
<html lang="en">
{{-- INI HALAMAN GALLERY --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">

        {{-- Tailwind via Vite --}}
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
</head>

<body>

    <div
        class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start bg-[url('/assets/images/bg2.png')] bg-cover bg-no-repeat">
        <div class="container w-full sm:w-[95%] lg:w-[80%]">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 sm:gap-0">
                <div class="bg-[#f0ebe3] rounded-t-3xl h-full py-4 sm:py-6 px-8 sm:px-20 shadow-[1.2vh_0_black] sm-h-full order-2 sm:order-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular]">Cho's Studio
                    </h1>
                </div>
                <div class="flex h-full order-1 sm:order-2 overflow-x-auto max-sm:gap-3 max-sm:justify-center">
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>
                            Home
                        </button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>
                            Gallery
                        </button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>
                            Shop
                        </button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-x-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>
                            Member
                        </button>
                    </div>

                </div>
            </div>
            <!-- Folder container: use column flex so header list + grid can size; min-h-0 enables child overflow -->
            <div class="bg-[#f0ebe3] rounded-b-3xl w-full shadow-[3vh_3vh_0_black] p-4 sm:p-8 h-[70vh] sm:h-[75vh] z-10 border-r-4 border-black flex flex-col min-h-0">
                <!-- top info stays fixed height (flex-none) -->
                <ul class="flex flex-col sm:flex-row font-[HammersmithOne-Regular] text-xs sm:text-sm lg:text-[1rem] gap-2 sm:gap-4 mx-2 sm:mx-4 flex-none">
                    <li>Illustrator / Artist</li>
                    <li>Graphic Designer</li>
                    <li>Original Fanmerch</li>
                </ul>

                <!-- grid wrapper: grows to fill remaining height and becomes scrollable when needed -->
                <div class="sm:mt-4 flex-1 min-h-0 overflow-auto">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4 auto-rows-fr h-full p-2 sm:p-4">
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
            </div>
        </div>

    </div>


    {{-- <div class="navbar absolute flex flex-row ml-[50%] mt-[0.5vh]">
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1rem]">
            Home
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1rem]">
            Gallery
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1rem]">
            Shop
        </button>
        <button
            class="flex justify-center items-center font-[HammersmithOne-Regular] bg-[#a2e1db] w-[20vh] h-[8.5vh] rounded-t-2xl outline border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-[1rem]">
            Member
        </button>
    </div> --}}

    {{-- isi konten halaman --}}
    {{-- <div class="folder block flex-row bg-black rounded-3xl w-[30%] h-[20%]"></div>

    <div
        class="fixed flex flex-col justify-center items-center bg-[#f0ebe3] rounded-3xl w-[28.5%] h-[19.5%] ml-[20.5vh] mt-[-18vh]">
        <h1 class="text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular] mt-[5%]">Cho's Studio</h1>
        <ul class="flex flex-row font-[HammersmithOne-Regular] text-[1rem] gap-4 m-4">
            <li>Illustrator / Artist</li>
            <li>Graphic Designer</li>
            <li>Original Fanmerch</li>
        </ul>
    </div> --}}

    {{-- <div
        class="folder flex justify-center flex-col bg-[#f0ebe3] w-[80%] h-[80%] mt-[-5%] p-10 rounded-3xl outline outline-4 outline-black shadow-[3vh_3vh_0_black]">
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
    </div> --}}

</body>

</html>
