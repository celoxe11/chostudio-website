@extends('member.member_template')

@section('content')
<div class="flex justify-center items-start pt-10 h-[89vh] overflow-hidden">
    <div class="flex flex-col w-[85vw] h-fit bg-[#f0ebe3] outline-4 rounded-2xl overflow-y-auto font-[HammersmithOne-Regular] p-10 relative">

        {{-- Tombol Go Back --}}
        <a href="{{ route('member.history') }}"
            class="absolute top-6 left-8 bg-[#c8f6e7] text-[#2c2c2c] px-4 py-2 rounded-full font-semibold flex items-center gap-2 shadow-md hover:bg-[#a8e8d5] transition-all duration-200">
            <i class="fa-solid fa-arrow-left"></i>
            Back to History
        </a>

        @php
            // Pastikan $item dikirim dari controller
            $bgColor = strtolower($item['type']) === 'commission' ? '#e1d8f7' : '#fce0ca';
            $borderColor = strtolower($item['type']) === 'commission' ? '#ad91f2' : '#f7c49c';

            $statusColors = [
                'pending' => ['#9ca3af', '#ffffff'],
                'on progress' => ['#34d399', '#ffffff'],
                'confirmed' => ['#6ee7b7', '#2c2c2c'],
                'finished' => ['#22c55e', '#ffffff'],
            ];
            $statusKey = strtolower($item['status']);
            $statusBg = $statusColors[$statusKey][0] ?? '#d1d5db';
            $statusText = $statusColors[$statusKey][1] ?? '#2c2c2c';
        @endphp

        {{-- Card --}}
        <div class="w-full rounded-2xl shadow-lg p-8 border-4 mt-10"
            style="background-color: {{ $bgColor }}; border-color: {{ $borderColor }};">
            
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-[#2c2c2c]">{{ $item['type'] }}</h2>
                <p class="text-lg opacity-80">{{ $item['title'] }}</p>
            </div>

            <div class="flex justify-between items-start space-x-8">
                <div class="flex flex-col w-[60%] space-y-4 text-[#2c2c2c]">
                    <div class="text-sm space-y-2">
                        <div class="flex gap-4">
                            <p><i class="fa-solid fa-calendar mr-2"></i> {{ $item['date'] }}</p>
                            @if(isset($item['file']))
                                <p><i class="fa-solid fa-file"></i> {{ $item['file'] }}</p>
                            @endif
                        </div>
                        <p><i class="fa-solid fa-money-bill-wave mr-2"></i> {{ $item['price'] }}</p>
                    </div>

                    <div class="text-sm mt-2">
                        @if($item['type'] == "Commission")
                            <p class="font-semibold mb-1">Commis Detail :</p>
                        @else
                            <p class="font-semibold mb-1">Description :</p>
                        @endif
                        <p class="bg-white p-4 rounded-lg leading-relaxed border border-[#cda98c] shadow-inner">
                            {{ $item['description'] }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-center justify-between h-full">
                    <div class="w-56 h-56 flex items-center justify-center rounded-lg overflow-hidden border-2 border-[#cda98c] shadow-md">
                        @if(isset($item['image']))
                            <img src="{{ $item['image'] }}" alt="Preview" class="object-cover w-full h-full rounded-lg">
                        @endif
                    </div>

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
