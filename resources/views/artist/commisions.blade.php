@extends('artist.artist_template')

@section('content')
    <div class="mt-8 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="shadow font-[HammersmithOne-Regular] overflow-x-auto">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-3 border-stone-900"
                style="background-color: var(--color-pastel-gray-turquoise);">
                <div class="text-2xl sm:text-4xl">Commisions</div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border-stone-900"
                        style="background-color: var(--status-danger);">0 Pending</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border-stone-900"
                        style="background-color: var(--status-info);">0 In Progress</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border-stone-900"
                        style="background-color: var(--status-warning);">0 Revision</div>
                </div>
            </div>
            <div class="h-[70vh] max-xl:h-[60vh] bg-(--color-background) border-2 border-stone-900 overflow-y-auto">
                <table class="w-full table-auto border-collapse">
                    <thead class="bg-stone-900 text-white">
                        <tr class="text-left bg-stone-900">
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900">
                                Customer</th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 bg-stone-900">
                                Category</th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">
                                Details
                            </th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden md:table-cell">
                                Price
                            </th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">
                                Due Date
                            </th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">
                                Status</th>
                            <th
                                class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $commissions = [
                                (object) [
                                    'customer' => 'Alice Smith',
                                    'email' => 'alice.smith@email.com',
                                    'category' => 'Fullbody',
                                    'details' => 'Fantasy Character Illustration',
                                    'price' => 'Rp. 150.000',
                                    'due_date' => '2024-07-20',
                                    'status_label' => 'In Progress (Sketch)',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'Bob Johnson',
                                    'email' => 'bob.johnson@email.com',
                                    'category' => 'Headshot',
                                    'details' => 'Sci-fi Character Portrait',
                                    'price' => 'Rp. 80.000',
                                    'due_date' => '2024-07-18',
                                    'status_label' => 'Pending',
                                    'payment_confirmed' => false,
                                ],
                                (object) [
                                    'customer' => 'Carol Davis',
                                    'email' => 'carol.davis@email.com',
                                    'category' => 'Chibi',
                                    'details' => 'Cute Animal Character',
                                    'price' => 'Rp. 50.000',
                                    'due_date' => '2024-07-22',
                                    'status_label' => 'Revision',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'David Wilson',
                                    'email' => 'david.wilson@email.com',
                                    'category' => 'Fullbody',
                                    'details' => 'Superhero Character Design',
                                    'price' => 'Rp. 200.000',
                                    'due_date' => '2024-07-25',
                                    'status_label' => 'Completed',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'Emma Thompson',
                                    'email' => 'emma.thompson@email.com',
                                    'category' => 'Fullbody',
                                    'details' => 'Magical Girl Character Design',
                                    'price' => 'Rp. 180.000',
                                    'due_date' => '2024-07-30',
                                    'status_label' => 'In Progress (Color)',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'Frank Miller',
                                    'email' => 'frank.miller@email.com',
                                    'category' => 'Headshot',
                                    'details' => 'Cyberpunk Character Portrait',
                                    'price' => 'Rp. 90.000',
                                    'due_date' => '2024-07-28',
                                    'status_label' => 'Pending',
                                    'payment_confirmed' => false,
                                ],
                            ];
                        @endphp

                        @php $commissionsList = $commissions ?? null; @endphp

                        @if (is_null($commissionsList) || count($commissionsList) === 0)
                            {{-- no commissions: show full-height placeholder --}}
                            <tr>
                                <td colspan="7" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-stone-700">No commissions to display</div>
                                    </div>
                                </td>
                            </tr>
                        @else
                            {{-- render each commission row --}}
                            @foreach ($commissionsList as $c)
                                <tr class="bg-(--color-background)">
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        <div class="font-semibold">{{ $c->customer ?? 'John Doe' }}</div>
                                        <div class="text-sm text-gray-600">{{ $c->email ?? 'john.doe@email.com' }}</div>
                                    </td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        {{ $c->category ?? 'Headshot' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                        {{ $c->details ?? 'Original Character Illustration' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden md:table-cell align-top">
                                        {{ $c->price ?? '$100' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                        {{ $c->due_date ?? '2024-07-15' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        <div
                                            class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                                            @if (!empty($c->status_label ?? false))
                                                <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: 
                                                @if ($c->status_label === 'Pending') var(--status-danger);
                                                @elseif ($c->status_label === 'In Progress (Sketch)' || $c->status_label === 'In Progress (Color)')
                                                    var(--status-info);
                                                @elseif ($c->status_label === 'Revision')
                                                    var(--status-warning);
                                                @elseif ($c->status_label === 'Completed')
                                                    var(--status-success);
                                                @else
                                                    var(--status-neutral); @endif
                                                ">{{ $c->status_label }}</button>
                                            @else
                                            @endif
                                            @if (!empty($c->payment_confirmed ?? false))
                                                <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: var(--status-success);">Payment
                                                    Confirmed</button>
                                            @else
                                                <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: var(--status-neutral);">No Confirmed
                                                    Payment</button>
                                            @endif
                                        </div>
                                    </td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:text-sm border border-stone-900 align-top">
                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                            <a
                                                href="{{ route("artist.commision_detail") }}"
                                                class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-green-600 transition-all duration-200"
                                                style="background-color: var(--status-success);">View</a>
                                            <a
                                                class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-yellow-500 text-yellow-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-yellow-500 transition-all duration-200"
                                                style="background-color: var(--status-warning);">Accept</a>
                                            <a
                                                class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-red-600 text-red-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-red-600 transition-all duration-200"
                                                style="background-color: var(--status-danger);">Decline</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- if only one commission, add a filler row to visually fill the container --}}
                            @if (count($commissionsList) === 1)
                                <tr>
                                    <td colspan="7" class="p-0 border-none align-top">
                                        <div class="min-h-[50vh] bg-(--color-background)"></div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>

            </div>


            <!-- Pagination (client-side) -->
            <div id="commissionsPager"
                class="bg-(--color-background) w-full flex flex-col sm:flex-row items-center justify-between gap-2 p-4 mt-2 border-3 border-stone-900">
                <div class="text-sm text-stone-900">Showing <span id="pagerRange">0</span> of <span id="pagerTotal">0</span>
                </div>
                <nav class="flex items-center gap-2" aria-label="Pagination">
                    <button id="pagerPrev" class="px-3 py-1 rounded bg-white border-3 border-stone-900 text-sm"
                        disabled>Previous</button>
                    <div id="pagerNumbers" class="flex items-center gap-1"></div>
                    <button id="pagerNext" class="px-3 py-1 rounded bg-white border-3 border-stone-900 text-sm"
                        disabled>Next</button>
                </nav>
            </div>
        </div>
    </div>
@endsection
