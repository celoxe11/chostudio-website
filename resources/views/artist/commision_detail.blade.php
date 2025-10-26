@extends('artist.artist_template')

@section('content')
    <div class="my-8 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="shadow font-[HammersmithOne-Regular]">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-2 border-stone-900"
                style="background-color: var(--color-pastel-gray-turquoise);">
                <a href="{{ route('artist.commisions') }}"
                    class="px-4 py-2 rounded-lg border-2 border-stone-500 bg-stone-100 text-stone-700 font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 text-center">
                    Back to Commissions
                </a>
                <div>
                    <div class="text-2xl sm:text-4xl">Commission Details</div>
                    {{-- <div class="text-lg max-lg:text-base">Order #{{ $commission->commision_id }}</div> --}}
                </div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    <div
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 {{ $commission->progress_status_color }}">
                        {{ $commission->progress_status_text }}
                    </div>
                    <div
                        class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 {{ $commission->payment_status_color }}">
                        {{ $commission->payment_status_text }}
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-(--color-background) border-2 border-t-0 border-stone-900 p-6 min-h-fit">
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Commission Details Section -->
                    <div class="lg:w-1/2 space-y-6">
                        <h2 class="text-2xl font-bold text-stone-900 border-b-2 border-stone-300 pb-2">Commission
                            Information</h2>

                        <!-- Progress Images Section -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Commission Progress Images</label>

                            @if ($commission->progressImages && $commission->progressImages->count() > 0)
                                <!-- Image Selector Dropdown -->
                                <div class="mb-3">
                                    <select id="progress-image-selector"
                                        class="w-full px-4 py-2 border-2 border-stone-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none font-semibold text-gray-700 shadow-sm">
                                        @foreach ($commission->progressImages as $index => $progress)
                                            <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                                                {{ $progress->stage_label }} - {{ $progress->created_at->format('M d, Y') }}
                                                @if ($progress->revision_notes)
                                                    - {{ Str::limit($progress->revision_notes, 40) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Image Display Container -->
                                <div class="bg-gray-100 rounded-lg p-4 border-2 border-stone-300">
                                    @foreach ($commission->progressImages as $index => $progress)
                                        <div class="progress-image-container {{ $index === 0 ? '' : 'hidden' }}"
                                            data-image-index="{{ $index }}">
                                            <img src="{{ asset($progress->image_link) }}"
                                                alt="{{ $progress->stage_label }}"
                                                class="max-w-full max-h-96 object-contain rounded-lg shadow-md mx-auto"
                                                onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />

                                            <!-- Image Info -->
                                            <div class="mt-3 space-y-2">
                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                        {{ $progress->stage_label }}
                                                    </span>
                                                    <span class="text-sm text-gray-600">
                                                        {{ $progress->created_at->format('F j, Y \a\t g:i A') }}
                                                    </span>
                                                </div>
                                                @if ($progress->revision_notes)
                                                    <div class="bg-white p-3 rounded-lg border border-gray-200">
                                                        <p class="text-xs font-semibold text-gray-500 mb-1">Revision Notes:
                                                        </p>
                                                        <p class="text-sm text-gray-700">{{ $progress->revision_notes }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- No Images Available Message -->
                                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6 text-center">
                                    <svg class="w-16 h-16 mx-auto text-yellow-400 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-semibold text-yellow-800 mb-1">No Images Available Yet</p>
                                    <p class="text-sm text-yellow-700">Progress images will appear here once uploaded.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Commission Details -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                                    <div class="text-lg font-bold text-stone-900">{{ $commission->category }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                                    <div class="text-lg font-bold text-green-600">Rp
                                        {{ number_format($commission->price, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                                <div class="text-gray-800 leading-relaxed bg-gray-50 p-4 rounded-lg border">
                                    {{ $commission->description }}</div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deadline</label>
                                    <div class="text-gray-800 font-medium">
                                        {{ date('F j, Y', strtotime($commission->deadline)) }}</div>
                                    @php
                                        $daysLeft = ceil((strtotime($commission->deadline) - time()) / (60 * 60 * 24));
                                    @endphp
                                    @if ($daysLeft > 0)
                                        <div class="text-sm text-blue-600">{{ $daysLeft }} days remaining</div>
                                    @elseif($daysLeft == 0)
                                        <div class="text-sm text-orange-600">Due today</div>
                                    @else
                                        <div class="text-sm text-red-600">{{ abs($daysLeft) }} days overdue</div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Order Date</label>
                                    <div class="text-gray-800">
                                        {{ date('F j, Y \a\t g:i A', strtotime($commission->created_at)) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Client Information Section -->
                    <div class="lg:w-1/2 space-y-6">
                        <h2 class="text-2xl font-bold text-stone-900 border-b-2 border-stone-300 pb-2">Client Information
                        </h2>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                                <div class="text-lg font-bold text-stone-900">{{ $member->name }}</div>
                            </div>

                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                                <div class="text-gray-800">{{ $member->username }}</div>
                            </div>

                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                <div class="text-gray-800">
                                    <a href="mailto:{{ $member->email }}"
                                        class="text-blue-600 hover:underline">{{ $member->email }}</a>
                                </div>
                            </div>

                            @if ($member->phone_number)
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                                    <div class="text-gray-800">
                                        <a href="tel:{{ $member->phone_number }}"
                                            class="text-blue-600 hover:underline">{{ $member->phone_number }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($member->line_id)
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Line ID</label>
                                    <div class="text-gray-800">{{ $member->line_id }}</div>
                                </div>
                            @endif

                            @if ($member->instagram)
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Instagram</label>
                                    <div class="text-gray-800">
                                        <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}"
                                            target="_blank"
                                            class="text-blue-600 hover:underline">{{ $member->instagram }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Status Information -->
                        <div class="pt-4 border-t-2 border-stone-200">
                            <h3 class="text-lg font-bold text-stone-900 mb-3 border-b-2 border-stone-300">Status</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Progress</label>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $commission->progress_status_color }}">
                                        {{ $commission->progress_status_text }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Payment</label>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $commission->payment_status_color }}">
                                        {{ $commission->payment_status_text }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t-2 border-stone-200">
                            <h3 class="text-lg font-bold text-stone-900 mb-4 border-b-2 border-stone-300">Actions</h3>
                            <div class="flex flex-col gap-4">
                                @if ($commission->progress_status === 'pending')
                                    @include("artist.actions.pending_actions")
                                @elseif($commission->progress_status === 'accepted')
                                    @include("artist.actions.progress_status_update", ['commission' => $commission])
                                @elseif($commission->progress_status === 'in_progress_sketch')
                                    <!-- Progress Status Update -->
                                    
                                @elseif($commission->progress_status === 'revision')
                                    <button
                                        class="group relative px-6 py-3 rounded-xl border-2 border-orange-500 bg-orange-50 text-orange-700 font-bold shadow-lg hover:shadow-xl hover:bg-orange-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            Submit Revision
                                        </div>
                                        <div
                                            class="absolute inset-0 rounded-xl bg-orange-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                                        </div>
                                    </button>
                                @endif

                                
                            </>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle progress image selection
        document.addEventListener('DOMContentLoaded', function() {
            const selector = document.getElementById('progress-image-selector');

            if (selector) {
                selector.addEventListener('change', function() {
                    const selectedIndex = this.value;

                    // Hide all images
                    document.querySelectorAll('.progress-image-container').forEach(container => {
                        container.classList.add('hidden');
                    });

                    // Show selected image
                    const selectedContainer = document.querySelector(
                        `[data-image-index="${selectedIndex}"]`);
                    if (selectedContainer) {
                        selectedContainer.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
@endsection
