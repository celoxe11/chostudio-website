@extends('member.member_template')

@section('content')
<div class="flex justify-center items-center h-screen overflow-hidden">
    <div class="flex flex-col w-[85vw] h-[90vh] bg-[#f0ebe3] outline-4 rounded-2xl overflow-hidden font-[HammersmithOne-Regular] p-10">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl text-[#2c2c2c]">History (Payment)</h1>

            <div class="flex items-center space-x-2">
                <span class="text-[#2c2c2c]">Filter :</span>
                <div class="relative">
                    <select id="filterSelect"
                        class="appearance-none bg-[#c8f6e7] w-[20vw] text-[#2c2c2c] rounded px-4 py-2 pr-8 focus:outline-none cursor-pointer font-[HammersmithOne-Regular]">
                        <option value="recently" selected>recently add</option>
                        <option value="commision">commision</option>
                        <option value="oc art">oc art</option>
                        <option value="pending">pending</option>
                        <option value="on progress">on progress</option>
                        <option value="finished">finished</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-[#2c2c2c]"></i>
                </div>
            </div>
        </div>

        {{-- Cards --}}
        <div id="historyContainer" class="grid grid-cols-5 gap-5 pr-2">
            @foreach ($historyData as $item)
                @php
                    // Warna berdasarkan tipe
                    $bgColor = strtolower($item['type']) === 'commision' ? '#e1d8f7' : // putih
                               (strtolower($item['type']) === 'oc art' ? '#fce0ca' : '#e1d8f7');

                    $borderColor = strtolower($item['type']) === 'commision' ? '#c2b4e2' :
                                   (strtolower($item['type']) === 'oc art' ? '#f7c49c' : '#ccc');

                    // Warna tombol status (solid)
                    $statusColor = match (strtolower($item['status'])) {
                        'pending' => '#808080',     // abu-abu solid
                        'on progress' => '#62d6ac', // hijau toska
                        'confirmed' => '#81e39c',   // hijau muda
                        'finished' => '#5ad36a',    // hijau terang
                        default => '#cccccc',
                    };

                    $statusText = strtolower($item['status']) === 'pending' ? '#ffffff' : '#2c2c2c';
                @endphp

                <a href="{{ route('member.history_detail', $item['id']) }}"
                    class="history-card rounded-xl p-4 flex flex-col justify-between transition-all duration-200 hover:scale-105 hover:shadow-lg"
                    style="background-color: {{ $bgColor }}; border: 3px solid {{ $borderColor }}"
                    data-type="{{ strtolower($item['type']) }}"
                    data-status="{{ strtolower($item['status']) }}">
                    
                    <div class="text-center">
                        <h2 class="text-lg text-[#2c2c2c]">{{ $item['type'] }}</h2>
                        <p class="text-sm text-[#7b61ff] opacity-80">{{ $item['title'] }}</p>
                    </div>

                    <div class="text-sm text-[#2c2c2c] mt-2 space-y-1">
                        <p><i class="fa-solid fa-calendar"></i> {{ $item['date'] }}</p>
                        <p><i class="fa-solid fa-money-bill-wave"></i> {{ $item['price'] }}</p>
                    </div>

                    <button class="mt-3 rounded-full py-1 px-3 font-bold text-sm"
                        style="background-color: {{ $statusColor }}; color: {{ $statusText }};">
                        {{ $item['status'] }}
                    </button>
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('filterSelect');
        const cards = document.querySelectorAll('.history-card');

        select.addEventListener('change', function () {
            const filter = this.value.toLowerCase();

            cards.forEach(card => {
                const type = card.dataset.type;
                const status = card.dataset.status;

                if (filter === 'recently') {
                    card.style.display = 'flex';
                } else if (type === filter || status === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
