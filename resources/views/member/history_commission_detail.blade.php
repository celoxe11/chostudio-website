@extends('member.member_template')

@section('content')
    {{-- Main Container: Centered and full-height adaptive --}}
    <div class="flex justify-center items-start font-[HammersmithOne-Regular] overflow-auto py-12 px-6 sm:px-10 lg:px-20"
        style="min-height: calc(100vh - 80px)">

        {{-- Detail Card Container --}}
        <div
            class="w-full bg-[var(--color-background)] shadow-2xl border-3 border-stone-900 rounded-2xl p-6 lg:p-10 relative">

            {{-- Main Content Card (Commission Details) --}}
            <div class="w-full rounded-xl p-4 sm:p-6 md:p-8 border-4 border-purple-500 bg-purple-50 shadow-inner">

                {{-- Header/Back Button and Title --}}
                <div class="relative mb-8 text-center border-b border-purple-200 pb-4">
                    <a href="{{ route('member.history') }}"
                        class="md:absolute md:top-1/2 md:-translate-y-1/2 md:left-0 inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-cyan-700 bg-cyan-100 rounded-full shadow-md hover:bg-cyan-200 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to History
                    </a>
                    <h1 class="text-3xl font-extrabold text-gray-800 tracking-wide">Commission Details</h1>
                    <p class="text-lg text-gray-600 mt-1">{{ $commission->category }}</p>
                </div>

                <div class="flex flex-col lg:flex-row justify-between gap-8">

                    {{-- Left Column: Progress Images & Status (1/3 width) --}}
                    <div class="w-full lg:w-1/3 flex flex-col items-center space-y-6">

                        {{-- Progress Image Viewer --}}
                        <div class="w-full">
                            <h2
                                class="text-lg font-bold text-gray-800 mb-3 border-b-2 border-purple-200 pb-1 flex items-center gap-2">
                                <i class="fa-solid fa-paintbrush text-purple-600"></i> Progress Images
                            </h2>

                            @if ($commission->progressImages && $commission->progressImages->count() > 0)
                                <select id="progress-image-selector"
                                    class="w-full px-4 py-3 border-2 border-purple-300 rounded-xl bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 focus:outline-none font-semibold text-gray-700 shadow-sm transition-all duration-200 mb-4">
                                    @foreach ($commission->progressImages as $index => $progress)
                                        {{-- NOTE: Assuming stage_label is a property or accessor on CommissionProgress --}}
                                        <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                                            {{ $progress->stage_label ?? $progress->stage }} -
                                            {{ $progress->created_at->format('M d, Y') }}
                                            @if ($progress->revision_notes)
                                                - Revision ({{ Str::limit($progress->revision_notes, 20) }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                <div
                                    class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-3 border-2 border-gray-300 shadow-xl">
                                    @foreach ($commission->progressImages as $index => $progress)
                                        <div class="progress-image-container {{ $index === 0 ? '' : 'hidden' }}"
                                            data-image-index="{{ $index }}">
                                            <div class="bg-white rounded-lg shadow-inner">
                                                <img src="{{ asset($progress->image_link) }}"
                                                    alt="{{ $progress->stage_label ?? 'Progress' }}"
                                                    class="max-w-full max-h-80 object-contain rounded-lg mx-auto"
                                                    style="max-height: 300px; width: 100%;"
                                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPC9zdmc+'" />
                                            </div>

                                            @if ($progress->revision_notes)
                                                <div
                                                    class="mt-4 bg-blue-100 p-3 rounded-lg border border-blue-300 shadow-sm">
                                                    <p class="text-xs font-bold text-blue-700 uppercase tracking-wide mb-1">
                                                        Artist's Notes:</p>
                                                    <p class="text-sm text-gray-800 leading-snug">
                                                        {{ $progress->revision_notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div
                                    class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-8 text-center shadow-md">
                                    <i class="fa-solid fa-camera fa-2xl text-yellow-500 mb-4"></i>
                                    <p class="text-lg font-bold text-yellow-900 mb-2">No Images Yet</p>
                                    <p class="text-sm text-yellow-700">Progress images will appear once the artist starts
                                        the work.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Status Box --}}
                        <div class="w-full p-4 bg-white rounded-xl shadow-lg border-2 border-purple-200 text-gray-800">
                            <h3 class="text-lg font-extrabold text-center mb-3 border-b border-purple-100 pb-2">Order Status
                            </h3>

                            {{-- Payment Status --}}
                            <div class="flex justify-between items-center py-2">
                                <span class="font-bold">Payment:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $commission->payment_status_color }} text-sm font-medium shadow-md">
                                    {{ $commission->payment_status_text }}
                                </div>
                            </div>

                            {{-- Progress Status --}}
                            <div class="flex justify-between items-center py-2 border-t border-purple-100 mt-1">
                                <span class="font-bold">Progress:</span>
                                <div
                                    class="px-3 py-1 rounded-full text-white {{ $commission->progress_status_color }} text-sm font-medium shadow-md">
                                    {{ $commission->progress_status_text }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Details, Timeline, and Review/Action (2/3 width) --}}
                    <div class="w-full lg:w-2/3 flex flex-col space-y-6 text-gray-700">

                        {{-- Core Details Grid --}}
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="p-4 rounded-xl border-2 border-purple-300 bg-purple-100 shadow-inner">
                                <label class="block text-xs font-bold text-purple-700 mb-1 uppercase">Category</label>
                                <div class="text-lg font-bold text-purple-900">{{ $commission->category }}</div>
                            </div>
                            <div class="p-4 rounded-xl border-2 border-green-300 bg-green-100 shadow-inner">
                                <label class="block text-xs font-bold text-green-700 mb-1 uppercase">Price</label>
                                <div class="text-lg font-bold text-green-700">
                                    Rp {{ number_format($commission->price, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="p-4 rounded-xl border-2 border-orange-300 bg-orange-100 shadow-inner">
                                <label class="block text-xs font-bold text-orange-700 mb-1 uppercase">Deadline</label>
                                <div class="text-sm font-bold text-orange-900">
                                    {{ date('F j, Y', strtotime($commission->deadline)) }}
                                </div>
                                @php
                                    $daysLeft = ceil((strtotime($commission->deadline) - time()) / (60 * 60 * 24));
                                @endphp
                                @if ($daysLeft > 0)
                                    <div class="text-xs font-semibold text-blue-600 mt-1">{{ $daysLeft }} days left
                                    </div>
                                @elseif($daysLeft == 0)
                                    <div class="text-xs font-semibold text-orange-600 mt-1">Due today</div>
                                @else
                                    <div class="text-xs font-semibold text-red-600 mt-1">{{ abs($daysLeft) }} days overdue
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 rounded-xl border-2 border-blue-300 bg-blue-100 shadow-inner">
                                <label class="block text-xs font-bold text-blue-700 mb-1 uppercase">Order Date</label>
                                <div class="text-sm font-bold text-blue-900">
                                    {{ date('M j, Y \a\t g:i A', strtotime($commission->created_at)) }}
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div>
                            <p class="font-bold text-lg mb-2 border-b border-gray-200 pb-1">Commission Description:</p>
                            <div
                                class="bg-white p-4 rounded-xl leading-relaxed border border-gray-300 shadow-md min-h-[100px] text-sm">
                                <p>{{ $commission->description }}</p>
                            </div>
                        </div>

                        {{-- Client Action Area (Accept/Revision) --}}
                        @if ($commission->progress_status === 'review')
                            <div class="p-6 rounded-xl border-4 border-cyan-500 bg-cyan-50 shadow-2xl space-y-4">
                                <h3 class="text-xl font-extrabold text-cyan-700 flex items-center gap-2">
                                    <i class="fa-solid fa-feather-pointed"></i> Review Artist Work
                                </h3>
                                <p class="text-gray-700 text-sm">The artist has submitted a progress update. Please choose
                                    to **Accept** the current work or request a **Revision**.</p>

                                {{-- Action Buttons (Simplified for illustration, requires form/JS submission) --}}
                                <div class="flex flex-col sm:flex-row gap-4">
                                    {{-- ACCEPT Button --}}
                                    <button type="button"
                                        class="flex-1 px-6 py-3 rounded-full bg-green-500 text-white font-bold shadow-lg hover:bg-green-600 transition-all duration-200"
                                        onclick="document.getElementById('revision-form-area').classList.add('hidden'); console.log('Accept action triggered');">
                                        <i class="fa-solid fa-check-circle mr-2"></i> Accept Work
                                    </button>

                                    {{-- REVISION Button (Toggles form) --}}
                                    <button type="button" id="revision-toggle-btn"
                                        class="flex-1 px-6 py-3 rounded-full bg-orange-500 text-white font-bold shadow-lg hover:bg-orange-600 transition-all duration-200"
                                        onclick="document.getElementById('revision-form-area').classList.toggle('hidden');">
                                        <i class="fa-solid fa-pencil-ruler mr-2"></i> Request Revision
                                    </button>
                                </div>

                                {{-- Revision Form Area (Hidden by default) --}}
                                <div id="revision-form-area" class="hidden mt-4 pt-4 border-t border-cyan-300 space-y-3">
                                    <h4 class="text-lg font-bold text-orange-700">Revision Details</h4>
                                    <form action="{{-- [YOUR REVISION SUBMIT ROUTE HERE] --}}" method="POST">
                                        @csrf
                                        {{-- You might need to add hidden fields for commission_id and the current progress_id --}}

                                        <textarea name="revision_notes" rows="4"
                                            placeholder="Please clearly explain the specific changes needed (e.g., 'Change the hair color to a darker shade of blue', 'Adjust the pose of the left character')."
                                            class="w-full p-4 border-2 border-orange-300 rounded-lg focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 text-sm shadow-inner"
                                            required></textarea>

                                        <button type="submit"
                                            class="w-full mt-3 px-6 py-3 rounded-lg bg-orange-600 text-white font-extrabold shadow-md hover:bg-orange-700 transition-all duration-200">
                                            Submit Revision Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- Timeline --}}
                        <div class="p-4 bg-gray-100 rounded-xl border-2 border-gray-300 shadow-sm">
                            <p class="font-bold text-lg mb-2 border-b border-gray-300 pb-2 flex items-center gap-2">
                                <i class="fa-solid fa-clock-rotate-left text-gray-500"></i> Commission Timeline
                            </p>
                            <div class="grid grid-cols-2 gap-4 text-sm mt-2">
                                <p><strong><i class="fa-solid fa-calendar-check mr-2"></i>Started At:</strong>
                                    {{ optional($commission->started_at)->format('M j, Y') ?? 'N/A' }}</p>
                                <p><strong><i class="fa-solid fa-sack-dollar mr-2"></i>Fully Paid At:</strong>
                                    {{ optional($commission->fully_paid_at)->format('M j, Y') ?? 'N/A' }}</p>
                                <p><strong><i class="fa-solid fa-medal mr-2"></i>Completed At:</strong>
                                    {{ optional($commission->completed_at)->format('M j, Y') ?? 'N/A' }}</p>
                                @if ($commission->cancellation_reason)
                                    <p class="col-span-2 text-red-600"><strong><i class="fa-solid fa-ban mr-2"></i>Cancelled
                                            At:</strong>
                                        {{ optional($commission->cancelled_at)->format('M j, Y') ?? 'N/A' }} (Reason:
                                        {{ $commission->cancellation_reason }})</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script to handle image selector and revision form toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selector = document.getElementById('progress-image-selector');
            const imageContainers = document.querySelectorAll('.progress-image-container');
            const revisionFormArea = document.getElementById('revision-form-area');
            const revisionToggleBtn = document.getElementById('revision-toggle-btn');

            if (selector) {
                selector.addEventListener('change', function() {
                    const selectedIndex = this.value;
                    imageContainers.forEach(container => {
                        if (container.getAttribute('data-image-index') === selectedIndex) {
                            container.classList.remove('hidden');
                        } else {
                            container.classList.add('hidden');
                        }
                    });
                });
            }

            // Optional: Hide revision form if accept is clicked (Placeholder for actual form submission logic)
            // Note: In a real app, 'Accept Work' would submit a form/API call.
            // document.querySelector('button[onclick*="Accept action triggered"]').addEventListener('click', () => {
            //     revisionFormArea.classList.add('hidden');
            // });
        });
    </script>
@endsection
