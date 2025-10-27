<div class="xl:col-span-5 space-y-6">
    <div class="overflow-hidden">
        <div>
            <h2 class="text-2xl font-bold flex items-center gap-2 pb-4">
                Commission Info
            </h2>
        </div>

        <div class="space-y-5">
            <!-- Progress Images Section -->
            <div class="space-y-3">
                <label class="block text-sm font-bold text-gray-800 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Progress Images
                </label>

                @if ($commission->progressImages && $commission->progressImages->count() > 0)
                    <!-- Image Selector -->
                    <select id="progress-image-selector"
                        class="w-full px-4 py-3 border-2 border-stone-300 rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none font-semibold text-gray-700 shadow-sm hover:border-blue-400 transition-all duration-200">
                        @foreach ($commission->progressImages as $index => $progress)
                            <option value="{{ $index }}" {{ $index === 0 ? 'selected' : '' }}>
                                {{ $progress->stage_label }} -
                                {{ $progress->created_at->format('M d, Y') }}
                                @if ($progress->revision_notes)
                                    - {{ Str::limit($progress->revision_notes, 30) }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <!-- Image Display -->
                    <div
                        class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-5 border-2 border-stone-300 shadow-inner">
                        @foreach ($commission->progressImages as $index => $progress)
                            <div class="progress-image-container {{ $index === 0 ? '' : 'hidden' }}"
                                data-image-index="{{ $index }}">
                                <div class="bg-white rounded-lg p-2 shadow-lg">
                                    <img src="{{ asset($progress->image_link) }}" alt="{{ $progress->stage_label }}"
                                        class="max-w-full max-h-80 object-contain rounded-lg mx-auto"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span
                                            class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-md">
                                            {{ $progress->stage_label }}
                                        </span>
                                        <span class="text-xs text-gray-600 font-semibold">
                                            {{ $progress->created_at->format('F j, Y \a\t g:i A') }}
                                        </span>
                                    </div>
                                    @if ($progress->revision_notes)
                                        <div class="bg-white p-3 rounded-xl border-2 border-blue-200 shadow-sm">
                                            <p class="text-xs font-bold text-blue-600 mb-1 uppercase tracking-wide">
                                                Revision Notes:</p>
                                            <p class="text-sm text-gray-800 leading-relaxed">
                                                {{ $progress->revision_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-8 text-center shadow-md">
                        <svg class="w-20 h-20 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-lg font-bold text-yellow-900 mb-2">No Images Yet</p>
                        <p class="text-sm text-yellow-700">Progress images will appear once uploaded.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Commission Details -->
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border-2 border-purple-200 shadow-sm">
                        <label
                            class="block text-xs font-bold text-purple-700 mb-2 uppercase tracking-wide">Category</label>
                        <div class="text-lg font-bold text-purple-900">{{ $commission->category }}
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border-2 border-green-200 shadow-sm">
                        <label class="block text-xs font-bold text-green-700 mb-2 uppercase tracking-wide">Price</label>
                        <div class="text-lg font-bold text-green-700">Rp
                            {{ number_format($commission->price, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border-2 border-gray-200 shadow-sm">
                    <label
                        class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Description</label>
                    <div class="text-gray-800 leading-relaxed text-sm">{{ $commission->description }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div
                        class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-xl border-2 border-orange-200 shadow-sm">
                        <label
                            class="block text-xs font-bold text-orange-700 mb-2 uppercase tracking-wide">Deadline</label>
                        <div class="text-sm font-bold text-orange-900">
                            {{ date('F j, Y', strtotime($commission->deadline)) }}</div>
                        @php
                            $daysLeft = ceil((strtotime($commission->deadline) - time()) / (60 * 60 * 24));
                        @endphp
                        @if ($daysLeft > 0)
                            <div class="text-xs font-semibold text-blue-600 mt-1">
                                {{ $daysLeft }} days left</div>
                        @elseif($daysLeft == 0)
                            <div class="text-xs font-semibold text-orange-600 mt-1">Due today</div>
                        @else
                            <div class="text-xs font-semibold text-red-600 mt-1">
                                {{ abs($daysLeft) }} days overdue</div>
                        @endif
                    </div>
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200 shadow-sm">
                        <label class="block text-xs font-bold text-blue-700 mb-2 uppercase tracking-wide">Order
                            Date</label>
                        <div class="text-sm font-bold text-blue-900">
                            {{ date('M j, Y', strtotime($commission->created_at)) }}</div>
                        <div class="text-xs text-blue-700 mt-1">
                            {{ date('g:i A', strtotime($commission->created_at)) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
