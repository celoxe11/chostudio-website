@extends('template')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div
            class="flex flex-col relative justify-center items-center bg-[#f0ebe3] w-[95%] md:w-[85%] lg:w-[80%] h-[80%] p-8 rounded-3xl border-4 border-black">
            {{-- Back to home --}}
            <div class="absolute top-10 left-10 w-full flex justify-start mb-4">
                <a href={{ route("home") }}
                    class="font-[HammersmithOne-Regular] bg-[#a2e1db] hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-base px-4 py-2 rounded-2xl border-4 border-black">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>

            {{-- judul --}}
            <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
                <h1 class="text-3xl md:text-5xl lg:text-5xl">LOGIN</h1>
            </div>

            <form class="flex flex-col items-center gap-4 w-full max-w-md" action="" method="post">
                @csrf
                <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                    type="text" name="username" id="username" placeholder="Username" required>
                <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                    type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit"
                    class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full py-4 text-xl rounded-2xl outline hover:bg-[#477c77] transition-colors duration-300 ease-in-out">Login</button>
            </form>

            <div class="flex flex-col items-center gap-3 mt-6">
                <a href="/register"
                    class="text-lg font-semibold text-black hover:text-[#ffac81] transition-colors duration-300">
                    Don't have an account? Register here
                </a>
            </div>
        </div>
    </div>
@endsection
