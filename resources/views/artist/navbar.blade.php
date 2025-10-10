<div class="font-[HammersmithOne-Regular] bg-stone-900 text-white sticky top-0 z-50 w-full">
    <div class="flex justify-between items-center p-4 xl:w-[80%] mx-auto lg:w-full">
        <div class="flex gap-3 items-end">
            <a href="{{ route('artist.commisions') }}" class="text-6xl font-bold max-lg:text-3xl">Cho's Studio</a>
            <p class="text-2xl max-lg:text-lg max-m:text-base">ARTIST</p>
        </div>

        <div class="flex gap-5 items-center">
             <!-- Desktop nav -->
        <nav class="hidden md:block text-3xl max-xl:text-base font-bold">
            <ul class="flex gap-8">
                <li><a href="{{route('artist.gallery')}}" class="hover:underline underline-offset-1 decoration-2">Gallery</a></li>
                <li><a href="" class="hover:underline underline-offset-1 decoration-2">History</a></li>
                <li><a href="{{ route('artist.commisions') }}" class="hover:underline underline-offset-1 decoration-2">Commisions</a></li>
            </ul>
        </nav>
            <button class="py-2 px-4 rounded bg-(--status-danger) text-white text-2xl max-xl:text-base font-bold hover:scale-105 transition-transform duration-300">
                LOGOUT
            </button>
        </div>

        <!-- Mobile hamburger -->
        <div class="md:hidden">
            <button data-nav-toggle aria-controls="mobileSidebar" aria-expanded="false" aria-label="Open navigation"
                class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                <!-- simple hamburger icon -->
                <svg id="hamburgerIcon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile sidebar (hidden by default) -->
    <aside id="mobileSidebar" class="fixed inset-y-0 left-0 w-64 bg-stone-900 text-white transform -translate-x-full transition-transform duration-200 ease-in-out z-50" aria-hidden="true">
        <div class="p-4 flex items-center justify-between">
            <div class="text-2xl font-bold">Cho's Studio</div>
            <button id="navClose" aria-label="Close navigation" class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="p-4 text-lg">
            <ul class="flex flex-col gap-4">
                <li><a href="{{ route('artist.gallery') }}" class="block">Gallery</a></li>
                <li><a href="" class="block">History</a></li>
                <li><a href="{{ route('artist.commisions') }}" class="block">Commisions</a></li>
            </ul>
        </nav>
    </aside>

    <!-- backdrop for mobile when sidebar open -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-200 z-40"></div>

    <!-- Inline script to toggle sidebar (keeps change local and simple) -->
    <script>
        (function () {
            const toggles = document.querySelectorAll('[data-nav-toggle]');
            const sidebar = document.getElementById('mobileSidebar');
            const closeBtn = document.getElementById('navClose');
            const backdrop = document.getElementById('sidebarBackdrop');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.setAttribute('aria-hidden', 'false');
                toggles.forEach(t => t.setAttribute('aria-expanded', 'true'));
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.setAttribute('aria-hidden', 'true');
                toggles.forEach(t => t.setAttribute('aria-expanded', 'false'));
                backdrop.classList.add('opacity-0', 'pointer-events-none');
            }

            toggles.forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const expanded = this.getAttribute('aria-expanded') === 'true';
                    expanded ? closeSidebar() : openSidebar();
                });
            });
            closeBtn && closeBtn.addEventListener('click', closeSidebar);
            backdrop && backdrop.addEventListener('click', closeSidebar);
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeSidebar();
            });
        })();

        // =============================
        // 💰 Auto-format harga (contoh: 100000 -> 100.000)
        // =============================
        const priceInput = document.getElementById('priceInput');
        if (priceInput) {
            // Format angka ke format Indonesia
            function formatRupiah(value) {
                if (!value) return '';
                return new Intl.NumberFormat('id-ID').format(value.replace(/\D/g, ''));
            }

            priceInput.addEventListener('input', (e) => {
                const value = e.target.value.replace(/\D/g, ''); // Hapus non-digit
                if (!value) {
                    e.target.value = '';
                    return;
                }
                e.target.value = formatRupiah(value);
            });

            // Saat submit form: ubah ke angka mentah (tanpa titik)
            const form = priceInput.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    priceInput.value = priceInput.value.replace(/\./g, '');
                });
            }
        }
        </script>

</div>

