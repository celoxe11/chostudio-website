@extends('artist.artist_template')

@section('content')
    <div class="mt-8 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="shadow font-[HammersmithOne-Regular] overflow-x-auto">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-3 border-stone-900"
                style="background-color: var(--color-pastel-gray-turquoise);">
                <div class="text-2xl sm:text-4xl">Adoptions</div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border-stone-900"
                        style="background-color: var(--status-danger);">0 Pending</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2 border-2 border-stone-900"
                        style="background-color: var(--status-info);">0 Delivered</div>
                </div>
            </div>
            <div class="h-[70vh] max-xl:h-[60vh] bg-(--color-background) border-2 border-stone-900 overflow-y-auto">
                <table class="w-full h-full table-auto border-collapse">
                    <thead class="bg-stone-900 text-white">
                        <tr class="text-left">
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900">Buyer</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900">Art Title</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">Art Description
                            </th>
                            </th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">Order Date
                            </th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">Status</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="h-full">
                        @php
                            $adoptions = [
                                (object) [
                                    'buyer' => 'Alice Smith',
                                    'email' => 'alice.smith@email.com',
                                    'artwork' => 'Dragon Warrior OC',
                                    'description' => 'Fantasy dragon humanoid character design',
                                    'order_date' => '2024-10-05',
                                    'status_label' => 'Delivered',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'buyer' => 'Bob Johnson',
                                    'email' => 'bob.johnson@email.com',
                                    'artwork' => 'Cyberpunk Cat Girl',
                                    'description' => 'Futuristic neko character with cybernetic enhancements',
                                    'order_date' => '2024-10-03',
                                    'status_label' => 'Pending',
                                    'payment_confirmed' => false,
                                ],
                                (object) [
                                    'buyer' => 'Carol Davis',
                                    'email' => 'carol.davis@email.com',
                                    'artwork' => 'Forest Fairy',
                                    'description' => 'Magical woodland sprite character',
                                    'order_date' => '2024-10-01',
                                    'status_label' => 'Delivered',
                                    'payment_confirmed' => true,
                                ],
                            ];
                        @endphp

                        @php $adoptionsList = $adoptions ?? null; @endphp

                        @if (is_null($adoptionsList) || count($adoptionsList) === 0)
                            {{-- no adoptions: show full-height placeholder --}}
                            <tr>
                                <td colspan="7" class="p-0 border-none align-top">
                                    <div class="min-h-[60vh] flex items-center justify-center bg-(--color-background)">
                                        <div class="text-lg max-md:p-1 text-stone-700">No adoption orders to display</div>
                                    </div>
                                </td>
                            </tr>
                        @else
                            {{-- render each adoption row --}}
                            @foreach ($adoptionsList as $a)
                                <tr class="bg-(--color-background)">
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        <div class="font-semibold">{{ $a->buyer ?? 'John Doe' }}</div>
                                        <div class="text-sm text-gray-600">{{ $a->email ?? 'john.doe@email.com' }}</div>
                                    </td>
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        {{ $a->artwork ?? 'Character Design' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                        {{ $a->description ?? 'Original Character Artwork' }}</td>
                                    <td
                                        class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell align-top">
                                        {{ $a->order_date ?? '2024-10-01' }}</td>
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        <div
                                            class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                                            @php
                                                $statusColor = match($a->status_label) {
                                                    'Pending' => 'var(--status-danger)',
                                                    'Delivered' => 'var(--status-info)',
                                                    default => 'var(--status-neutral)'
                                                };
                                            @endphp
                                            <button disabled class="px-3 py-1 rounded-full"
                                                style="background-color: {{ $statusColor }};">{{ $a->status_label ?? 'Pending' }}</button>
                                            @if (!empty($a->payment_confirmed ?? false))
                                                 <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: var(--status-success);">Payment Confirmed</button>
                                            @else
                                                <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: var(--status-neutral);">Payment Pending</button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:text-sm border border-stone-900 align-top">
                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                            <a href="{{ route('artist.adoption_detail') }}"
                                            class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-green-600 transition-all duration-200"
                                                style="background-color: var(--status-success);">View</a>
                                            @if($a->status_label === 'Pending')
                                                <a class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-blue-500 text-blue-800 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-blue-500 transition-all duration-200"
                                                    style="background-color: var(--status-info);">Confirm</a>
                                                <a class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-red-600 text-red-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-red-600 transition-all duration-200"
                                                    style="background-color: var(--status-danger);">Reject</a>
                                            @elseif($a->status_label === 'Confirmed')
                                                <a class="px-2 py-1 rounded-lg w-full sm:w-auto border-2 border-green-600 text-green-900 font-semibold shadow-md hover:shadow-lg hover:scale-105 hover:bg-green-600 transition-all duration-200"
                                                    style="background-color: var(--status-success);">Mark Delivered</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- if only one adoption, add a filler row to visually fill the container --}}
                            @if (count($adoptionsList) === 1)
                                <tr>
                                    <td colspan="7" class="p-0 border-none align-top">
                                        <div class="min-h-[55vh] bg-(--color-background)"></div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>

            </div>


            <!-- Pagination (client-side) -->
            <div id="commissionsPager" class="bg-(--color-background) w-full flex flex-col sm:flex-row items-center justify-between gap-2 p-4 mt-2 border-3 border-stone-900">
                <div class="text-sm text-stone-900">Showing <span id="pagerRange">0</span> of <span id="pagerTotal">0</span>
                </div>
                <nav class="flex items-center gap-2" aria-label="Pagination">
                    <button id="pagerPrev"
                        class="px-3 py-1 rounded bg-white border-3 border-stone-900 text-sm"
                        disabled>Previous</button>
                    <div id="pagerNumbers" class="flex items-center gap-1"></div>
                    <button id="pagerNext"
                        class="px-3 py-1 rounded bg-white border-3 border-stone-900 text-sm"
                        disabled>Next</button>
                </nav>
            </div>
        </div>
    </div>
@endsection