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
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md text-white {{ $adoption->order_status_color }} border-2 border-opacity-50">
                        {{ $adoption->order_status_text }}
                    </span>
                    <span
                        class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md text-white {{ $adoption->payment_status_color }} border-2 border-opacity-50">
                        {{ $adoption->payment_status_text }}
                    </span>
                </div>
            </div>

            <div class="bg-(--color-background) p-6 min-h-fit border-4 border-stone-900">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Left Column: Artwork Information (50%) -->
                    <div class="space-y-6 lg:col-span-2">
                        <div class="overflow-hidden">
                            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                                Artwork Info
                            </h2>

                            <div class="space-y-5">
                                <!-- Artwork Image -->
                                <div class="space-y-3">
                                    <label
                                        class="block text-sm font-bold text-gray-800 uppercase tracking-wide flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Artwork Preview
                                    </label>

                                    <div
                                        class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-5 border-2 border-stone-300 shadow-inner">
                                        <div class="bg-white rounded-lg p-2 shadow-lg">
                                            <img src="{{ asset($adoption->gallery->image_url) }}" alt="{{ $adoption->gallery->title }}"
                                                class="max-w-full max-h-80 object-contain rounded-lg mx-auto"
                                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Artwork Details -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div
                                            class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border-2 border-purple-200 shadow-sm">
                                            <label
                                                class="block text-xs font-bold text-purple-700 mb-2 uppercase tracking-wide">Title</label>
                                            <div class="text-lg font-bold text-purple-900">{{ $adoption->gallery->title }}</div>
                                        </div>
                                        <div
                                            class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 rounded-xl border-2 border-indigo-200 shadow-sm">
                                            <label
                                                class="block text-xs font-bold text-indigo-700 mb-2 uppercase tracking-wide">File
                                                Format</label>
                                            <div class="text-lg font-bold text-indigo-900">{{ $adoption->gallery->file_format }}
                                            </div>
                                        </div>
                                        <div
                                            class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border-2 border-green-200 shadow-sm">
                                            <label
                                                class="block text-xs font-bold text-green-700 mb-2 uppercase tracking-wide">Price</label>
                                            <div class="text-lg font-bold text-green-700">Rp
                                                {{ number_format($adoption->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>


                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200 shadow-sm">
                                        <label
                                            class="block text-xs font-bold text-blue-700 mb-2 uppercase tracking-wide">Description</label>
                                        <div class="text-sm text-blue-900 leading-relaxed">{{ $adoption->gallery->description }}
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Buyer Information + Actions (50%) -->
                    <div class="space-y-8">
                        <!-- Buyer Information Section -->
                        <div class="overflow-hidden">
                            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                                Buyer Info
                            </h2>

                            <div class="space-y-4">
                                <div class="flex items-center gap-4 bg-white p-4 rounded-xl shadow-sm">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-sm">
                                        {{ strtoupper(substr($adoption->buyer_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-xl font-bold text-stone-900 mb-1">{{ $adoption->buyer_name }}
                                        </div>
                                        <div class="text-sm text-gray-600">Buyer</div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div
                                        class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 shadow-sm">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <a href="mailto:{{ $adoption->buyer_email }}"
                                            class="text-sm text-blue-600 hover:underline font-medium">{{ $adoption->buyer_email }}</a>
                                    </div>

                                    <div
                                        class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200 shadow-sm">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm text-gray-800 font-medium">
                                            {{ $adoption->created_at->format('F j, Y \a\t g:i A') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Section -->
                        <div class="overflow-hidden">
                            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                                Actions
                            </h2>

                            <div class="flex flex-col gap-4">
                                @if ($adoption->order_status === 'pending')
                                    <!-- Pending Actions -->
                                    <button
                                        class="w-full px-6 py-4 rounded-xl border-2 border-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2"
                                        style="background-color: var(--status-info);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Confirm Order
                                    </button>
                                    <button
                                        class="w-full px-6 py-4 rounded-xl border-2 border-red-600 text-white font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2"
                                        style="background-color: var(--status-danger);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel Order
                                    </button>
                                @elseif($adoption->order_status === 'confirmed' && $adoption->payment_status === 'unpaid')
                                    <!-- Confirmed but Unpaid -->
                                    <div
                                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-yellow-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-yellow-900 mb-2">Awaiting Payment</h4>
                                                <p class="text-sm text-yellow-800 leading-relaxed">The order is confirmed.
                                                    Waiting for buyer's payment confirmation.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="w-full px-6 py-4 rounded-xl border-2 border-green-600 text-white font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2"
                                        style="background-color: var(--status-success);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Confirm Payment
                                    </button>
                                @elseif($adoption->order_status === 'processing' && $adoption->payment_status === 'paid')
                                    <!-- Processing -->
                                    <div
                                        class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-purple-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-purple-900 mb-2">Processing Order</h4>
                                                <p class="text-sm text-purple-800 leading-relaxed">Payment received.
                                                    Preparing files for delivery.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="w-full px-6 py-4 rounded-xl border-2 border-purple-600 text-white font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center justify-center gap-2"
                                        style="background-color: var(--status-neutral);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark as Delivered
                                    </button>
                                @elseif($adoption->order_status === 'delivered')
                                    <!-- Delivered -->
                                    <div
                                        class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-green-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-green-900 mb-2">Files Delivered</h4>
                                                <p class="text-sm text-green-800 leading-relaxed">The artwork files have
                                                    been successfully delivered to the buyer.</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($adoption->order_status === 'completed')
                                    <!-- Completed -->
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-blue-900 mb-2">Order Completed</h4>
                                                <p class="text-sm text-blue-800 leading-relaxed">This adoption order has
                                                    been completed successfully.</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($adoption->order_status === 'cancelled')
                                    <!-- Cancelled -->
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-300 rounded-xl p-6 shadow-md">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-14 h-14 bg-gray-500 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-gray-900 mb-2">Order Cancelled</h4>
                                                <p class="text-sm text-gray-800 leading-relaxed">This adoption order has
                                                    been cancelled.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
