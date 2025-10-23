@extends('member.member_template')

@section('content')
<div class="flex justify-center h-full overflow-hidden ">
    <div class="flex justify-center items-center bg-[#f0ebe3] border-4 border-black h-[70%] w-[70%] overflow-hidden m-10 rounded-2xl shadow-md">
    <div class="flex flex-col items-center">
        <p class="font-semibold mb-6">Choose Artwork Type</p>
        <div class="flex flex-row gap-8">
            <!-- Head Shot -->
            <div class="flex flex-col items-center rounded-2xl overflow-hidden bg-gray-100 shadow hover:shadow-lg transition duration-300 cursor-pointer">
                <img src="{{ asset('assets/images/sample.jpeg') }}" 
                     alt="Commission Head Shot" 
                     class="w-[160px] h-[240px] object-cover">
                <p class="py-3 font-medium text-sm text-gray-800">Head Shot</p>
            </div>

            <!-- Half Body -->
            <div class="flex flex-col items-center rounded-2xl overflow-hidden bg-gray-100 shadow hover:shadow-lg transition duration-300 cursor-pointer">
                <img src="{{ asset('assets/images/sample.jpeg') }}" 
                     alt="Commission Half Body" 
                     class="w-[160px] h-[240px] object-cover">
                <p class="py-3 font-medium text-sm text-gray-800">Half Body</p>
            </div>

            <!-- Full Body -->
            <div class="flex flex-col items-center rounded-2xl overflow-hidden bg-gray-100 shadow hover:shadow-lg transition duration-300 cursor-pointer">
                <img src="{{ asset('assets/images/sample.jpeg') }}" 
                     alt="Commission Full Body" 
                     class="w-[160px] h-[240px] object-cover">
                <p class="py-3 font-medium text-sm text-gray-800">Full Body</p>
            </div>

            <!-- Custom -->
            <div class="flex flex-col items-center rounded-2xl overflow-hidden bg-gray-100 shadow hover:shadow-lg transition duration-300 cursor-pointer">
                <img src="{{ asset('assets/images/sample.jpeg') }}" 
                     alt="Commission Custom" 
                     class="w-[160px] h-[240px] object-cover">
                <p class="py-3 font-medium text-sm text-gray-800">Custom</p>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
