@extends('member.member_template')

@section('content')
    {{-- Main Container: Centered and full-height adaptive --}}
    <div class="flex justify-center items-start font-[HammersmithOne-Regular] overflow-auto py-12 px-6 sm:px-10 lg:px-20"
        style="min-height: calc(100vh - 80px)">

        {{-- Detail Card Container --}}
        <div
            class="w-full bg-[var(--color-background)] shadow-2xl border-3 border-stone-900 rounded-2xl p-6 lg:p-10 relative">

            {{-- Main Content Card (Artwork Details and Image) --}}
            <div class="w-full rounded-xl p-4 sm:p-6 md:p-8 border-4 border-amber-500 bg-amber-50 shadow-inner">

                {{-- Header/Back Button and Title (Consistent Layout) --}}
                <div class="relative mb-8 text-center border-b border-amber-200 pb-4">
                    <a href="{{ route('member.history') }}"
                        class="md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-cyan-700 bg-cyan-100 rounded-full shadow-md hover:bg-cyan-200 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to History
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide">Adoption Details</h1>
                    <p class="text-lg text-gray-600 mt-1">"{{ $adoption->gallery->title }}"</p>
                </div>

                <div class="flex flex-col lg:flex-row justify-between gap-8">

                    {{-- Left Column: Artwork Image & Status (Consistent Width: lg:w-2/5) --}}
                    <div class="w-full lg:w-2/5 flex flex-col items-center space-y-6">

                        <div class="bg-white rounded-xl p-3 border-2 border-gray-300 shadow-xl">
                            {{-- Image/Preview --}}
                            <div class="w-full rounded-xl overflow-hidden shadow-xl border-4 border-amber-400 bg-white">
                                @if (isset($adoption->gallery->image_url))
                                    <div class="bg-white rounded-lg shadow-inner">
                                        <img src="{{ asset($adoption->gallery->image_url) }}" alt="Artwork Preview"
                                            class="w-full h-full object-cover">
                                    </div>
                                @else
                                    {{-- Placeholder consistent with commission's missing image structure --}}
                                    <div
                                        class="w-full aspect-square flex items-center justify-center bg-gray-100 text-gray-400 text-sm">
                                        <i class="fa-solid fa-image fa-3x"></i>
                                        <p class="ml-3">No Image Available</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Status Box (Consistent Styling) --}}
                        <div
                            class="w-full flex flex-row items-center justify-between p-5 bg-gradient-to-br from-amber-50 to-white rounded-2xl shadow-xl border-2 border-amber-300 text-gray-900">
                            <h3
                                class="text-xl font-extrabold text-center tracking-wide text-amber-700 flex items-center justify-center gap-2">
                                Status
                            </h3>
                            <div class="flex flex-col sm:flex-row justify-center items-center gap-2">
                                <div
                                    class="px-4 py-1 rounded-full text-white {{ $adoption->payment_status_color }} text-base font-semibold shadow">
                                    {{ $adoption->payment_status_text }}
                                </div>
                                <div
                                    class="px-4 py-1 rounded-full text-white {{ $adoption->order_status_color }} text-base font-semibold shadow">
                                    {{ $adoption->order_status_text }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Details and Description (Consistent Width: lg:w-3/5) --}}
                    <div class="w-full lg:w-3/5 flex flex-col space-y-6 text-gray-700">

                        {{-- Core Details Grid (Consistent Grid and Box Styling) --}}
                        <div class="grid grid-cols-3 gap-4 text-sm">

                            {{-- Order Date (Blue/Indigo Scheme for Dates/Order Info) --}}
                            <div class="p-4 rounded-xl border-2 border-blue-300 bg-blue-100 shadow-inner">
                                <label class="block text-xs font-bold text-blue-700 mb-1 uppercase">Order Date</label>
                                <div class="text-sm font-bold text-blue-900">
                                    {{ $adoption->created_at->format('M j, Y \a\t g:i A') }}
                                </div>
                            </div>

                            {{-- File Format (Indigo Scheme) --}}
                            <div class="p-4 rounded-xl border-2 border-indigo-300 bg-indigo-100 shadow-inner">
                                <label class="block text-xs font-bold text-indigo-700 mb-1 uppercase">File
                                    Format</label>
                                <div class="text-lg font-bold text-indigo-900">
                                    {{ $adoption->gallery->file_format }}
                                </div>
                            </div>

                            {{-- Price (Green Scheme) --}}
                            <div class="p-4 rounded-xl border-2 border-green-300 bg-green-100 shadow-inner">
                                <label class="block text-xs font-bold text-green-700 mb-1 uppercase">Price</label>
                                <div class="text-xl font-bold text-green-700">
                                    <i class="fa-solid fa-money-bill-wave mr-2"></i>
                                    Rp {{ number_format($adoption->gallery->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Artwork Description (Red/Themed Scheme) --}}
                        <div class="bg-red-50 p-4 rounded-xl border-2 border-red-300 shadow-sm">
                            <p class="font-bold text-lg mb-2 border-b border-red-200 pb-1 flex items-center gap-2">
                                Artwork Description
                            </p>
                            <div class="text-red-800 leading-relaxed text-sm">
                                <p>{{ $adoption->gallery->description }}</p>
                            </div>
                        </div>

                        {{-- Buyer Message (General Gray/White Scheme) --}}
                        <div class="bg-white p-4 rounded-xl border-2 border-gray-300 shadow-sm">
                            <p class="font-bold text-lg mb-2 border-b border-gray-200 pb-1 flex items-center gap-2">
                                Buyer's Message
                            </p>
                            <div class="text-gray-800 leading-relaxed text-sm">
                                <p>{{ $adoption->buyer_message }}</p>
                            </div>
                        </div>

                        <div
                            class="w-full p-5 bg-gradient-to-br from-white to-amber-50 rounded-2xl shadow-xl border-2 border-amber-300">
                            <p
                                class="font-bold text-lg mb-3 border-b border-amber-200 pb-2 flex items-center gap-2 text-amber-700">
                                Transaction Timeline
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm mt-2">
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-calendar-check text-amber-600"></i>
                                    <span class="font-semibold">Confirmed At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->confirmed_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-sack-dollar text-amber-600"></i>
                                    <span class="font-semibold">Paid At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->paid_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-box text-amber-600"></i>
                                    <span class="font-semibold">Delivered At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->delivered_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center gap-2 p-2 rounded-lg bg-amber-100 border border-amber-200">
                                    <i class="fa-solid fa-star text-amber-600"></i>
                                    <span class="font-semibold">Completed At:</span>
                                    <span
                                        class="ml-auto">{{ optional($adoption->completed_at)->format('M j, Y \a\t H:i') ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
