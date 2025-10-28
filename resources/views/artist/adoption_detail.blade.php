@extends('artist.artist_template')

@section('content')
    <style>
        .custom-swal-popup {
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-text {
            font-size: 16px;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }
    </style>

    <div class="my-8 max-xl:mt-3 p-4 xl:w-[90%] mx-auto lg:w-full">
        <div class="shadow-2xl font-[HammersmithOne-Regular] overflow-hidden">
            <!-- Header Section -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between items-center gap-3 p-6 border-t-4 border-x-4 border-stone-900 bg-(--color-pastel-turqoise)">
                <a href="{{ route('artist.adoptions') }}"
                    class="group px-5 py-2.5 rounded-xl border-2 border-stone-600 bg-white text-stone-800 font-bold shadow-lg hover:shadow-xl hover:scale-105 hover:bg-stone-50 transition-all duration-300 text-center flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Adoptions
                </a>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-bold text-stone-900 drop-shadow-sm">Adoption Details</div>
                    <div class="text-sm text-stone-700 mt-1">Order #{{ $adoption->adoption_id }}</div>
                </div>
                <div class="flex flex-wrap gap-2 items-center justify-center sm:justify-end">
                    <span
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md {{ $adoption->order_status_color }} text-white">
                        {{ $adoption->order_status_text }}
                    </span>
                    <span
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md {{ $adoption->payment_status_color }} text-white">
                        {{ $adoption->payment_status_text }}
                    </span>
                </div>
            </div>

            <div class="bg-(--color-background) p-6 min-h-fit border-4 border-stone-900">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    @include('artist.adoption_detail_column.artwork_info', [
                        'adoption' => $adoption,
                    ])

                    @include('artist.adoption_detail_column.buyer_info', [
                        'adoption' => $adoption,
                    ])

                    <!-- Right Column: Actions & Delivery Notes -->
                    <div class="space-y-6">
                        <!-- Actions Section -->
                        <div class="overflow-hidden">
                            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Order Actions
                            </h2>

                            @if ($adoption->order_status === 'pending')
                                {{-- confirm or cancel --}}
                                @include('artist.adoption_detail_column.actions.pending_actions', [
                                    'adoption' => $adoption,
                                ])
                            @elseif($adoption->order_status === 'confirmed')
                                @include('artist.adoption_detail_column.actions.confirmed_actions', [
                                    'adoption' => $adoption,
                                ])
                            @elseif($adoption->order_status === 'processing')
                                {{-- upload image --}}
                                @include('artist.adoption_detail_column.actions.processing_actions', [
                                    'adoption' => $adoption,
                                ])
                            @elseif($adoption->order_status === 'completed' || $adoption->order_status === 'delivered')
                                {{-- complete message --}}
                                @include('artist.adoption_detail_column.actions.adoption_complete', [
                                    'adoption' => $adoption,
                                ])
                            @elseif($adoption->order_status === 'cancelled')
                                {{-- cancelled message --}}
                                @include('artist.adoption_detail_column.actions.adoption_cancelled', [
                                    'adoption' => $adoption,
                                ])
                            @endif
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
