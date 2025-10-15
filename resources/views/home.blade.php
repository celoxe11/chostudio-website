<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>

    {{-- Tailwind via Vite --}}
    @vite('resources/css/app.css')

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
</head>

<body class="flex flex-row items-center h-screen">

    {{-- Sidebar --}}
    <aside class="flex flex-col items-center h-full w-[25%] bg-[#f0ebe3] border-r-4 border-black">

        {{-- Persona Image --}}
        <div class="bg-[#a2e1db] w-[30vh] h-[30vh] m-3">
            <img src="{{ asset('assets/cho_asset/Talking cho.png') }}" alt="Cho's OC" class="w-full h-full object-contain">
        </div>

        {{-- Title --}}
        <a href="{{ url('/home') }}"
           class="flex items-center justify-center h-[12vh] w-[70%] m-3 p-2
                  bg-[#ffac81] text-[#f0ebe3] text-[4vh] font-[HammersmithOne-Regular] font-bold
                  rounded-2xl outline outline-3 outline-black shadow-[1vh_1vh_0_black]">
            CHO.LAZEY
        </a>

        {{-- Socials --}}
        <div class="flex items-center gap-3 my-2 text-black">
            {{-- Instagram --}}
            <a href="https://instagram.com" class="flex items-center gap-1 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                </svg>
                Instagram
            </a>

            {{-- LINE --}}
            <a href="https://line.me" class="flex items-center gap-1 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-line" viewBox="0 0 16 16">
                    <path d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0M5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.15.15 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157m.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832l-.013-.015v-.001l-.01-.01-.003-.003-.011-.009h-.001L7.88 4.79l-.003-.002-.005-.003-.008-.005h-.002l-.003-.002-.01-.004-.004-.002-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.2.2 0 0 0 .039.038l.001.001.01.006.004.002.008.004.007.003.005.002.01.003h.003a.2.2 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.16.16 0 0 0-.108.044h-.001l-.001.002-.002.003a.16.16 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.16.16 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                </svg>
                LINE
            </a>
        </div>

        {{-- Navigation Buttons --}}
        <nav class="mt-4 font-[HammersmithOne-Regular]">
            @php
                $buttons = [
                    ['Gallery', '/gallery'],
                    ['Shop', '#'],
                    ['Member', '#'],
                ];
            @endphp

            <ul>
                @foreach ($buttons as [$label, $link])
                    <li class="m-3">
                        <a href="{{ url($link) }}"
                           class="flex justify-center items-center p-3 w-[30vh]
                                  bg-[#a2e1db] hover:bg-[#b4a6d5]
                                  rounded-2xl outline outline-1 outline-black">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

    </aside>

    {{-- Main Content --}}
    <main class="flex items-center justify-center h-full w-full
                 bg-[url('{{ asset('assets/images/Background.png') }}')] bg-no-repeat bg-cover">
        <section class="flex flex-col justify-center bg-[#f0ebe3]
                        w-[80%] h-[80%] p-10 rounded-3xl outline outline-4 outline-black
                        shadow-[3vh_3vh_0_black] font-[HammersmithOne-Regular]">

            {{-- About --}}
            <div class="mb-6 mt-[5vh]">
                <h1 class="text-3xl lg:text-4xl font-bold">About The Artist</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero eum esse in provident dignissimos
                   reiciendis molestias assumenda nesciunt autem expedita.</p>
            </div>

            {{-- Recent Works --}}
            <div class="bg-blue-300 flex-1 p-4 rounded-xl">
                <h1 class="text-3xl lg:text-4xl font-bold mb-2">Recent Works</h1>
                <p>biru cuma buat nunjukkin tinggi sih</p>
            </div>

            {{-- Description --}}
            <div class="mt-[5vh]">
                <p class="font-bold text-lg">Judul</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero eum esse in provident dignissimos
                   reiciendis molestias assumenda nesciunt autem expedita.</p>
            </div>
        </section>
    </main>

</body>
</html>
