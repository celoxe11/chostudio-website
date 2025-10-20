@extends('artist.artist_template')

@section('content')
    <div class="p-4 xl:w-[80%] mx-auto lg:w-full">
        @php
            // Sample data - replace with actual data from your controller
            $commission = (object) [
                'commision_id' => 'COM001',
                'category' => 'Fullbody',
                'description' =>
                    'Fantasy character illustration with detailed armor, magical effects, and dynamic pose. Character should have dragon-like features and mystical powers.',
                'deadline' => '2024-11-15',
                'price' => 150000,
                'image_url' => '/assets/cho_asset/Deafen cho.png', // Reference image provided by client
                'payment_status' => 'Paid', // Pending, Paid, Partial, Failed
                'progres_status' => 'In Progress', // Pending, In Progress, Revision, Completed, Cancelled
                'created_at' => '2024-10-05 09:15:00',
            ];

            $member = (object) [
                'member_id' => 'MBR001',
                'name' => 'Alice Smith',
                'username' => 'alice_art_lover',
                'email' => 'alice.smith@email.com',
                'line_id' => 'alice.smith.line',
                'phone_number' => '+62 812-3456-7890',
                'instagram' => '@alice_art_collection',
            ];
        @endphp

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
                    @php
                        $progressStatusColor = match ($commission->progres_status) {
                            'Pending' => 'var(--status-danger)',
                            'In Progress' => 'var(--status-info)',
                            'Revision' => 'var(--status-warning)',
                            'Completed' => 'var(--status-success)',
                            'Cancelled' => 'var(--status-neutral)',
                            default => 'var(--status-neutral)',
                        };

                        $paymentStatusColor = match ($commission->payment_status) {
                            'Pending' => 'var(--status-warning)',
                            'Paid' => 'var(--status-success)',
                            'Partial' => 'var(--status-info)',
                            'Failed' => 'var(--status-danger)',
                            default => 'var(--status-neutral)',
                        };
                    @endphp
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: {{ $progressStatusColor }};">{{ $commission->progres_status }}</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: {{ $paymentStatusColor }};">{{ $commission->payment_status }}</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-(--color-background) border-2 border-t-0 border-stone-900 p-6 min-h-fit">
                <div class="flex flex-col lg:flex-row gap-8">

                    <!-- Commission Details Section -->
                    <div class="lg:w-1/2 space-y-6">
                        <h2 class="text-2xl font-bold text-stone-900 border-b-2 border-stone-300 pb-2">Commission
                            Information</h2>

                        <!-- Reference Image (if provided) -->
                        @if ($commission->image_url)
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Commission Progress</label>
                                <div class="bg-gray-100 rounded-lg p-4 border-2 border-stone-300 w-fit mx-auto">
                                    <img src="{{ $commission->image_url }}" alt="Commission Reference"
                                        class="max-w-full max-h-96 object-contain rounded-lg shadow-md"
                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTAwVjIwME0xNTAgMTUwSDI1MCIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPHRLEHT+'" />
                                </div>
                            </div>
                        @endif

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
                            <h3 class="text-lg font-bold text-stone-900 mb-3">Status</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Progress</label>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        style="background-color: {{ $progressStatusColor }};">
                                        {{ $commission->progres_status }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Payment</label>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium"
                                        style="background-color: {{ $paymentStatusColor }};">
                                        {{ $commission->payment_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="pt-4 border-t-2 border-stone-200">
                            <h3 class="text-lg font-bold text-stone-900 mb-4">Actions</h3>
                            <div class="flex flex-col gap-4">
                                @if ($commission->progres_status === 'Pending')
                                    <div class="grid grid-cols-1 gap-3">
                                        <button
                                            class="group relative px-6 py-3 rounded-xl border-2 border-green-500 bg-green-50 text-green-700 font-bold shadow-lg hover:shadow-xl hover:bg-green-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Accept Commission
                                            </div>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-green-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                                            </div>
                                        </button>
                                        <button
                                            class="group relative px-6 py-3 rounded-xl border-2 border-red-500 bg-red-50 text-red-700 font-bold shadow-lg hover:shadow-xl hover:bg-red-100 hover:-translate-y-1 transform transition-all duration-300 ease-out">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Decline Commission
                                            </div>
                                            <div
                                                class="absolute inset-0 rounded-xl bg-red-200 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                                            </div>
                                        </button>
                                    </div>
                                @elseif($commission->progres_status === 'In Progress')
                                    <!-- Progress Status Update -->
                                    <div
                                        class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border-2 border-blue-200">
                                        <label for="progress_status" class="block text-sm font-bold text-blue-800 mb-3">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Update Progress Status
                                        </label>
                                        <div class="flex gap-3">
                                            <select id="progress_status" name="progress_status"
                                                class="flex-1 px-4 py-3 border-2 border-blue-300 rounded-xl bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none font-semibold text-gray-700 shadow-md transition-all duration-200">
                                                <option value="In Progress"
                                                    {{ $commission->progres_status === 'In Progress' ? 'selected' : '' }}>
                                                    In Progress
                                                </option>
                                                <option value="Revision"
                                                    {{ $commission->progres_status === 'Revision' ? 'selected' : '' }}>
                                                    Request Revision
                                                </option>
                                                <option value="Completed"
                                                    {{ $commission->progres_status === 'Completed' ? 'selected' : '' }}>
                                                    Mark Complete
                                                </option>
                                            </select>
                                            <button type="button"
                                                class="group px-6 py-3 rounded-xl border-2 border-blue-500 bg-blue-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-blue-600 hover:-translate-y-1 transform transition-all duration-300 ease-out">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    Save
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                @elseif($commission->progres_status === 'Revision')
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

                                <!-- File Upload Section -->
                                <div
                                    class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-4 border-2 border-purple-200">
                                    <label for="progress_upload" class="block text-sm font-bold text-purple-800 mb-3">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        Upload Progress Image
                                    </label>
                                    <div class="flex flex-row gap-3">
                                        <div class="relative group flex-1">
                                            <input type="file" name="progress_image" id="progress_upload"
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                                accept=".jpg,.jpeg,.png,.gif" />
                                            <div
                                                class="flex items-center justify-center gap-3 p-4 border-2 border-dashed border-purple-300 rounded-xl bg-white hover:bg-purple-25 hover:border-purple-400 transition-all duration-200 cursor-pointer group-hover:shadow-md">
                                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                                <div class="text-center">
                                                    <span class="text-purple-700 font-semibold">Click to upload</span>
                                                    <span class="text-purple-500"> or drag and drop</span>
                                                </div>
                                            </div>
                                            <div id="file-name"
                                                class="hidden mt-2 text-sm text-gray-600 bg-purple-50 px-3 py-2 rounded-lg border border-purple-200">
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="group px-6 py-3 rounded-xl border-2 border-purple-500 bg-purple-500 text-white font-bold shadow-lg hover:shadow-xl hover:bg-purple-600 hover:-translate-y-1 transform transition-all duration-300 ease-out">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Upload
                                            </div>
                                        </button>
                                    </div>
                                    <p class="text-xs text-purple-600 mt-2 font-medium">Supported formats: JPG, PNG, GIF
                                        (Max 10MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
