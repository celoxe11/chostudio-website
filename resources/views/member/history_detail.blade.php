@extends('member.member_template')

@section('content')
<div class="flex justify-center items-center h-screen overflow-hidden">
    <div class="flex w-[85vw] h-[90vh] bg-[#f0ebe3] outline-4 rounded-2xl overflow-hidden font-[HammersmithOne-Regular] p-10">

        @php
            // Background dan border berdasarkan tipe
            $bgColor = strtolower($item['type']) === 'commission' ? '#e1d8f7' : '#fce0ca';
            $borderColor = strtolower($item['type']) === 'commission' ? '#c2b4e2' : '#f7c49c';

            // Warna tombol status solid
            $statusColors = [
                'pending' => ['#9ca3af', '#ffffff'],        // abu
                'on progress' => ['#34d399', '#ffffff'],   // hijau mint
                'confirmed' => ['#6ee7b7', '#2c2c2c'],     // hijau muda
                'finished' => ['#22c55e', '#ffffff'],      // hijau solid
            ];

            $statusKey = strtolower($item['status']);
            $statusBg = $statusColors[$statusKey][0] ?? '#d1d5db';
            $statusText = $statusColors[$statusKey][1] ?? '#2c2c2c';
        @endphp

        {{-- Card --}}
        <div class="w-full h-fit rounded-2xl shadow-lg p-8 border-4"
            style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">

            {{-- Title --}}
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-[#2c2c2c]">{{ $item['type'] }}</h2>
                <p class="text-lg opacity-80">{{ $item['title'] }}</p>
            </div>

            <div class="flex justify-between items-start space-x-8">
                {{-- Left Section --}}
                <div class="flex flex-col w-[60%] space-y-4 text-[#2c2c2c]">
                    {{-- Info --}}
                    <div class="text-sm space-y-2">
                        <p><i class="fa-solid fa-calendar mr-2"></i> {{ $item['date'] }}</p>
                        <p><i class="fa-solid fa-money-bill-wave mr-2"></i> {{ $item['price'] }}</p>
                    </div>

                    {{-- Description --}}
                    <div class="text-sm mt-2">
                        <p class="font-semibold mb-1">Description :</p>
                        <p class="bg-white p-4 rounded-lg leading-relaxed border border-[#cda98c] shadow-inner">
                            {{ $item['description'] }}
                        </p>
                    </div>
                </div>

                {{-- Right Section --}}
                <div class="flex flex-col items-center justify-between h-full">
                    <div class="w-56 h-56 flex items-center justify-center rounded-lg overflow-hidden border-2 border-[#cda98c] shadow-md">
                        <img src="{{ $item['image'] }}" alt="Preview" class="object-cover w-full h-full rounded-lg">
                    </div>

                    {{-- Status --}}
                    <div class="mt-6 text-center">
                        <span class="font-semibold text-[#2c2c2c]">Status:</span>
                        <button class="ml-2 font-bold px-5 py-1 rounded-full shadow-md"
                            style="background-color: {{ $statusBg }}; color: {{ $statusText }};">
                            {{ $item['status'] }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
