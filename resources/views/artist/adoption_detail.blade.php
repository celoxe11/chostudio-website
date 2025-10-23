@extends('artist.artist_template')

@section('content')
    <div class="my-8 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        @php
            // Sample data - replace with actual data from your controller
            $adoption = (object) [
                'adoption_id' => 'ADT001',
                'email' => 'alice.smith@email.com',
                'order_status' => 'Confirmed', // Pending, Confirmed, Delivered, Cancelled
                'payment_status' => 'Paid', // Pending, Paid, Failed
                'created_at' => '2024-10-05 14:30:00',
            ];

            $gallery = (object) [
                'gallery_id' => 'GAL001',
                'title' => 'Dragon Warrior OC',
                'description' =>
                    'A fierce dragon humanoid warrior character with detailed armor and mystical powers. Perfect for fantasy stories or RPG characters.',
                'image_url' => '/assets/cho_asset/Deafen cho.png',
                'file_format' => 'PNG',
                'status' => 'Available',
                'price' => 120000,
            ];
        @endphp

        <div class="shadow font-[HammersmithOne-Regular] overflow-x-auto">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-2 border-stone-900"
                style="background-color: var(--color-pastel-gray-turquoise);">
                <a href="{{ route('artist.adoptions') }}"
                    class="px-6 py-3 rounded-lg border-2 border-stone-500 bg-stone-100 text-stone-700 font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 text-center">
                    Back to Adoptions
                </a>
                <div>
                    <div class="text-2xl sm:text-4xl">Adoption Details</div>
                    {{-- <div class="text-lg max-lg:text-base">Order #{{ $adoption->adoption_id }}</div> --}}
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    @php
                        $orderStatusColor = match ($adoption->order_status) {
                            'Pending' => 'var(--status-danger)',
                            'Confirmed' => 'var(--status-info)',
                            'Delivered' => 'var(--status-success)',
                            'Cancelled' => 'var(--status-neutral)',
                            default => 'var(--status-neutral)',
                        };

                        $paymentStatusColor = match ($adoption->payment_status) {
                            'Pending' => 'var(--status-warning)',
                            'Paid' => 'var(--status-success)',
                            'Failed' => 'var(--status-danger)',
                            default => 'var(--status-neutral)',
                        };
                    @endphp
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: {{ $orderStatusColor }};">{{ $adoption->order_status }}</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: {{ $paymentStatusColor }};">{{ $adoption->payment_status }}</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-(--color-background) border-2 border-t-0 border-stone-900 p-6 min-h-fit">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 auto-rows-min">

                    <!-- Artwork Section -->
                    <div class="space-y-6">
                        <h2 class="text-2xl font-bold text-stone-900 border-b-2 border-stone-300 pb-2">Artwork Information
                        </h2>

                        <!-- Artwork Image -->
                        <div class="bg-gray-100 rounded-lg p-4 border-2 border-stone-300 w-fit mx-auto">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                class="max-w-full max-h-96 object-contain rounded-lg shadow-md"
                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEDT+'" />
                        </div>
                    </div>

                    <!-- Order Information Section -->
                    <div class="space-y-6">
                        <!-- Artwork Details -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                                <div class="text-lg font-bold text-stone-900">{{ $gallery->title }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                                <div class="text-gray-800 leading-relaxed">{{ $gallery->description }}</div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">File Format</label>
                                    <div class="text-gray-800">{{ $gallery->file_format }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                                    <div class="text-lg font-bold text-green-600">Rp
                                        {{ number_format($gallery->price, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold text-stone-900 border-b-2 border-stone-300 pb-2">Order Information
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Buyer Email</label>
                                <div class="text-gray-800">{{ $adoption->email }}</div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Order Date</label>
                                <div class="text-gray-800">
                                    {{ date('F j, Y \a\t g:i A', strtotime($adoption->created_at)) }}</div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Order Status</label>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        style="background-color: {{ $orderStatusColor }}; color: white;">
                                        {{ $adoption->order_status }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Payment Status</label>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        style="background-color: {{ $paymentStatusColor }}; color: white;">
                                        {{ $adoption->payment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-6 border-t-2 border-stone-200">
                            <h3 class="text-lg font-bold text-stone-900 mb-4">Actions</h3>
                            <div class="flex flex-col sm:flex-row gap-3">
                                @if ($adoption->order_status === 'Pending')
                                    <button
                                        class="px-6 py-3 rounded-lg border-2 border-blue-500 text-white font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                                        style="background-color: var(--status-info);">
                                        Confirm Order
                                    </button>
                                    <button
                                        class="px-6 py-3 rounded-lg border-2 border-red-600 text-white font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                                        style="background-color: var(--status-danger);">
                                        Reject Order
                                    </button>
                                @elseif($adoption->order_status === 'Confirmed')
                                    <button
                                        class="px-6 py-3 rounded-lg border-2 border-green-600 text-white font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                                        style="background-color: var(--status-success);">
                                        Mark as Delivered
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
