@extends('artist.artist_template')

@section('content')
    <div class="mt-8 max-xl:mt-3 p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="shadow font-[HammersmithOne-Regular] overflow-x-auto">
            <div class="rounded-t-xl max-lg:rounded-t-lg flex flex-col sm:flex-row sm:items-end justify-between gap-3 p-4 border-2 border-stone-900"
                style="background-color: var(--color-turquoise);">
                <div class="text-2xl sm:text-4xl">Commisions</div>
                <div class="flex flex-wrap gap-2 sm:gap-4 items-center">
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: var(--status-danger);">0 Pending</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: var(--status-info);">0 In Progress</div>
                    <div class="text-lg max-lg:text-base max-sm:text-sm rounded-full px-3 sm:px-4 py-1 sm:py-2"
                        style="background-color: var(--status-warning);">0 Revision</div>
                </div>
            </div>
            <div class="h-[70vh] max-xl:h-[60vh] bg-(--color-background) border-2 border-stone-900 overflow-y-auto">
                <table class="w-full h-full table-auto border-collapse">
                    <thead class="bg-stone-900 text-white">
                        <tr class="text-left">
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900">Customer</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900">Category</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">Details
                            </th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden md:table-cell">Price
                            </th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 hidden sm:table-cell">Due Date
                            </th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">Status</th>
                            <th class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="h-full">
                        @php
                            $commissions = [
                                (object) [
                                    'customer' => 'Alice Smith',
                                    'category' => 'Fullbody',
                                    'details' => 'Fantasy Character Illustration',
                                    'price' => 'Rp. 150.000',
                                    'due_date' => '2024-07-20',
                                    'status_label' => 'In Progress',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'Bob Johnson',
                                    'category' => 'Headshot',
                                    'details' => 'Sci-fi Character Portrait',
                                    'price' => 'Rp. 80.000',
                                    'due_date' => '2024-07-18',
                                    'status_label' => 'Pending',
                                    'payment_confirmed' => false,
                                ],
                                (object) [
                                    'customer' => 'Carol Davis',
                                    'category' => 'Chibi',
                                    'details' => 'Cute Animal Character',
                                    'price' => 'Rp. 50.000',
                                    'due_date' => '2024-07-22',
                                    'status_label' => 'Revision',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'David Wilson',
                                    'category' => 'Fullbody',
                                    'details' => 'Superhero Character Design',
                                    'price' => 'Rp. 200.000',
                                    'due_date' => '2024-07-25',
                                    'status_label' => 'Completed',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'David Wilson',
                                    'category' => 'Fullbody',
                                    'details' => 'Superhero Character Design',
                                    'price' => 'Rp. 200.000',
                                    'due_date' => '2024-07-25',
                                    'status_label' => 'Completed',
                                    'payment_confirmed' => true,
                                ],
                                (object) [
                                    'customer' => 'David Wilson',
                                    'category' => 'Fullbody',
                                    'details' => 'Superhero Character Design',
                                    'price' => 'Rp. 200.000',
                                    'due_date' => '2024-07-25',
                                    'status_label' => 'Completed',
                                    'payment_confirmed' => true,
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
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        {{ $c->customer ?? 'John Doe' }}</td>
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
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
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:p-1 border border-stone-900 align-top">
                                        <div
                                            class="flex flex-col text-lg max-lg:text-base max-sm:text-sm max-md:text-sm md:text-base sm:flex-row gap-2 items-center justify-center">
                                            <button disabled class="px-3 py-1 rounded-full"
                                                style="background-color: var(--status-danger);">{{ $c->status_label ?? 'Pending' }}</button>
                                            @if (!empty($c->payment_confirmed ?? false))
                                                {{-- nothing extra --}}
                                            @else
                                                <button disabled class="px-3 py-1 rounded-full"
                                                    style="background-color: var(--status-neutral);">No Confirmed
                                                    Payment</button>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-3 md:p-4 text-lg max-lg:text-base max-sm:text-sm max-md:text-sm border border-stone-900 align-top">
                                        <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                            <button class="px-3 py-1 rounded-full w-full sm:w-auto"
                                                style="background-color: var(--status-success);">View</button>
                                            <button class="px-3 py-1 rounded-full w-full sm:w-auto"
                                                style="background-color: var(--status-warning);">Accept</button>
                                            <button class="px-3 py-1 rounded-full w-full sm:w-auto"
                                                style="background-color: var(--status-danger);">Decline</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- if only one commission, add a filler row to visually fill the container --}}
                            @if (count($commissionsList) === 1)
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
            <div id="commissionsPager" class="bg-(--color-background) w-full flex flex-col sm:flex-row items-center justify-between gap-2 p-4 mt-2 border border-3 border-stone-900">
                <div class="text-sm text-stone-600">Showing <span id="pagerRange">0</span> of <span id="pagerTotal">0</span>
                </div>
                <nav class="flex items-center gap-2" aria-label="Pagination">
                    <button id="pagerPrev"
                        class="px-3 py-1 rounded bg-white border border-stone-300 text-sm disabled:opacity-50"
                        disabled>Previous</button>
                    <div id="pagerNumbers" class="flex items-center gap-1"></div>
                    <button id="pagerNext"
                        class="px-3 py-1 rounded bg-white border border-stone-300 text-sm disabled:opacity-50"
                        disabled>Next</button>
                </nav>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const table = document.querySelector('table.w-full');
            if (!table) return;
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr')).filter(r => !r.querySelector('.min-h-[60vh]') && !r
                .querySelector('.min-h-[55vh]'));

            const perPage = 5; // change as needed
            let current = 1;
            const total = Math.ceil(rows.length / perPage) || 1;

            const pagerPrev = document.getElementById('pagerPrev');
            const pagerNext = document.getElementById('pagerNext');
            const pagerNumbers = document.getElementById('pagerNumbers');
            const pagerRange = document.getElementById('pagerRange');
            const pagerTotal = document.getElementById('pagerTotal');

            function render() {
                rows.forEach((r, i) => {
                    const page = Math.floor(i / perPage) + 1;
                    r.style.display = (page === current) ? '' : 'none';
                });

                pagerPrev.disabled = current === 1;
                pagerNext.disabled = current === total;
                pagerNumbers.innerHTML = '';
                for (let i = 1; i <= total; i++) {
                    const btn = document.createElement('button');
                    btn.textContent = i;
                    btn.className = 'px-2 py-1 rounded ' + (i === current ? 'bg-stone-900 text-white' :
                        'bg-white border border-stone-300');
                    btn.addEventListener('click', () => {
                        current = i;
                        render();
                    });
                    pagerNumbers.appendChild(btn);
                }

                const start = (rows.length === 0) ? 0 : ((current - 1) * perPage + 1);
                const end = Math.min(rows.length, current * perPage);
                pagerRange.textContent = (rows.length === 0) ? 0 : `${start}-${end}`;
                pagerTotal.textContent = rows.length;
            }

            pagerPrev.addEventListener('click', () => {
                if (current > 1) {
                    current--;
                    render();
                }
            });
            pagerNext.addEventListener('click', () => {
                if (current < total) {
                    current++;
                    render();
                }
            });

            // init
            render();
        })();
    </script>
@endpush
