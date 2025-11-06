@extends('template')

@section('content')
    {{-- Latar belakang utama --}}
    <div
        class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start bg-[url('{{ asset('assets/images/bg2.png') }}')] bg-cover bg-no-repeat">
        <div class="container w-full sm:w-[95%] lg:w-[80%]">
            {{-- Header & Navigasi --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 sm:gap-0">
                <div
                    class="bg-[#f0ebe3] rounded-t-3xl h-full py-4 sm:py-6 px-8 sm:px-20 shadow-black sm-h-full order-2 sm:order-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular]">Cho's
                        Studio</h1>
                </div>
                <div class="flex h-full order-1 sm:order-2 overflow-visible max-sm:gap-3 max-sm:justify-center">
                    {{-- Tombol Navigasi --}}
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/'">Home</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button onclick="window.location.href='/gallery'">Gallery</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Shop</button>
                    </div>
                    {{-- Tombol Member dengan Shadow yang dimodifikasi --}}
                    <div class="relative inline-block">
                        <div class="absolute top-1.5 left-1.5 w-full bg-black rounded-t-2xl z-[-1]" style="bottom: -3vh;">
                        </div>
                        <div
                            class="relative font-[HammersmithOne-Regular] bg-pastel-turqoise h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-x-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap z-10">
                            <button>Member</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GALERI ART TIDAK UNTUK DIJUAL --}}
            <div
                class="bg-[#f0ebe3] rounded-b-3xl w-full shadow-[3vh_3vh_0_black] p-4 sm:p-8 h-[70vh] sm:h-[75vh] z-10 border-r-4 border-black flex flex-col min-h-0">
                <ul
                    class="flex flex-col sm:flex-row font-[HammersmithOne-Regular] text-xs sm:text-sm lg:text-[1rem] gap-2 sm:gap-4 mx-2 sm:mx-4 flex-none">
                    <li>Illustrator / Artist</li>
                    <li>Graphic Designer</li>
                    <li>Original Fanmerch</li>
                </ul>
                <div class="sm:mt-4 flex-1 h-full overflow-auto">
                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4 auto-rows-fr h-full p-2 sm:p-4">
                        {{-- Bagian ini bisa Anda isi dengan galeri portofolio jika perlu --}}
                    </div>
                </div>
            </div>

            {{-- SECTION READY TO BUY --}}
            <section id="readyToBuy"
                class="mt-12 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10">
                <h2 class="font-[HammersmithOne-Regular] text-2xl sm:text-3xl text-center mb-6">
                    READY-TO-BUY DESIGNS
                </h2>
                <div class="flex flex-col sm:flex-row gap-6">
                    {{-- LEFT: PREVIEW --}}
                    <div id="previewPanel"
                        class="flex-1 bg-white border-4 border-black rounded-2xl shadow-[0.6vh_0.6vh_0_black] p-4 flex flex-col items-center justify-between w-full sm:w-[30vw] sm:min-w-[300px] transition-all duration-300">
                        <h3 id="previewTitle"
                            class="font-[HammersmithOne-Regular] text-xl sm:text-2xl mb-3 text-center">Select a Design</h3>
                        <div
                            class="w-full aspect-square bg-[#dceef4] rounded-xl overflow-hidden flex justify-center items-center">
                            <img id="previewImage" src="" alt="Preview" class="object-cover hidden w-full h-full">
                            <p id="previewPlaceholder" class="text-gray-500">Click an image to preview</p>
                        </div>
                        <div
                            class="w-full mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                <span id="previewFormat"
                                    class="px-3 py-1 bg-green-200 border border-black rounded-full text-sm font-semibold">-</span>
                                <span class="text-sm sm:text-lg font-semibold">Price:
                                    <span id="previewPrice">-</span></span>
                            </div>
                            <button id="buyButton" disabled
                                class="bg-[#4c9eff] border-4 border-black px-6 py-2 rounded-xl font-[HammersmithOne-Regular] hover:bg-[#73b7ff] transition duration-300 w-full sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed">
                                Buy Now
                            </button>
                        </div>
                    </div>
                    {{-- RIGHT: GRID (DIISI DARI DATABASE) --}}
                    <div id="designGrid"
                        class="grid grid-cols-3 sm:grid-cols-4 gap-2 flex-1 h-fit transition-all duration-300">
                        @forelse ($designs as $design)
                            @php
                                // If image_url is already an absolute URL or already under /storage, use it as-is.
                                $imageUrl = preg_match('/^https?:\/\//', $design->image_url) || str_starts_with($design->image_url, '/storage')
                                    ? $design->image_url
                                    : Storage::url($design->image_url);
                            @endphp
                            <div class="design-item cursor-pointer bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200"
                                data-id="{{ $design->gallery_id }}"
                                data-title="{{ $design->title }}"
                                data-price="Rp {{ number_format($design->price, 0, ',', '.') }}"
                                data-format="{{ $design->file_format }}"
                                data-image="{{ $imageUrl }}">
                                <img src="{{ $imageUrl }}" alt="{{ $design->title }}"
                                    class="w-full h-full object-cover rounded-sm border-2 border-black"
                                    onerror="handleBrokenImage(this)">
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500">No designs available for adoption at the moment.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- MODAL PEMBELIAN -->
    <div id="purchaseModal"
        class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4 font-[HammersmithOne-Regular]">
        <div class="bg-[#efeae4] rounded-2xl shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto border-4 border-black shadow-[1vh_1vh_0_#a2e1db]">
            <!-- FORM VIEW -->
            <div id="formView">
                <div class="bg-gradient-to-r from-[#a2e1db] to-[#7dc8c1] p-6 text-center rounded-t-xl">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Complete Your Purchase</h2>
                    <p class="text-gray-700">You are adopting: <strong id="modalItemTitle"
                            class="text-gray-900"></strong></p>
                </div>
                <form id="purchaseForm" method="POST" action="{{ route('gallery.adopt') }}" enctype="multipart/form-data"
                    class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    @csrf
                    <input type="hidden" name="gallery_id" id="gallery_id">

                    <!-- Kolom Kiri: QRIS -->
                    <div class="flex flex-col items-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Scan to Pay</h3>
                        <div class="w-full max-w-[250px]">
                            <img src="{{ asset('assets/images/payment/qris_cho_lazey_fanmerch.png') }}"
                                alt="QRIS Code" class="w-full rounded-lg shadow-md border-2 border-white">
                        </div>
                        <p class="text-center text-2xl font-bold text-red-600 mt-4" id="modalItemPrice"></p>
                        <p class="text-xs text-gray-600 mt-2 text-center">Please transfer the exact amount.</p>
                    </div>

                    <!-- Kolom Kanan: Input Form -->
                    <div class="flex flex-col justify-center">
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Your Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-2 border-2 border-black rounded-lg"
                                placeholder="your.email@example.com">
                        </div>
                        <div class="mt-4">
                            <label for="paymentProof" class="block text-sm font-bold text-gray-700 mb-1">Upload Payment
                                Proof</label>
                            <input type="file" id="paymentProof" name="paymentProof" required
                                accept="image/png, image/jpeg, image/jpg"
                                class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#a2e1db] file:text-gray-800 hover:file:bg-[#7dc8c1] border-2 border-black rounded-lg cursor-pointer">
                        </div>
                        <div class="mt-8 flex items-center gap-4">
                            <button type="submit" id="submitButton"
                                class="w-full bg-[#4c9eff] border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-[#73b7ff] transition duration-300">
                                Submit
                            </button>
                            <button type="button" id="closeModalButton"
                                class="w-1/2 bg-gray-300 border-4 border-black px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300">
                                Cancel
                            </button>
                        </div>
                        <div id="formErrors" class="text-red-500 text-sm mt-2"></div>
                    </div>
                </form>
            </div>

            <!-- THANK YOU VIEW -->
            <div id="thankYouView" class="hidden p-8 md:p-12 text-center">
                <div class="bg-gradient-to-r from-[#a2e1db] to-[#7dc8c1] p-6 rounded-t-xl mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Thank You!</h2>
                </div>
                <p class="text-lg text-gray-800 mb-4">
                    Your submission has been received. Please wait for confirmation from the artist via the email you provided.
                </p>
                <p class="text-sm text-gray-600 mb-6">
                    Verification may take up to 24 hours. Once your payment is verified, the artwork files will be sent to you.
                </p>
                <button id="finishButton" class="bg-gray-800 text-white px-8 py-3 rounded-xl font-bold hover:bg-black transition duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
            // expose server upload limit (bytes) to client so we can validate before sending
            @php
                $u = ini_get('upload_max_filesize');
                $last = strtolower(substr($u, -1));
                $mult = ($last === 'g') ? 1024*1024*1024 : (($last === 'm') ? 1024*1024 : (($last === 'k') ? 1024 : 1));
                $uploadMaxBytes = ((int)$u) * $mult;
            @endphp
            const SERVER_UPLOAD_MAX = {{ $uploadMaxBytes }}; // bytes
        document.addEventListener('DOMContentLoaded', function() {
            // Handle broken images: remove the containing card and log an error to console
            window.handleBrokenImage = function(img) {
                try {
                    const card = img.closest('.design-item');
                    const id = card ? card.dataset.id || card.dataset.index : null;
                    console.error('Broken image detected, removing card', { id: id, src: img.src });
                    if (card) card.remove();
                    // keep modal/preview placeholders intact; preview image errors will only log
                } catch (e) {
                    console.error('Error handling broken image', e);
                }
            };
            // Elemen UI
            const buyButton = document.getElementById('buyButton');
            const purchaseModal = document.getElementById('purchaseModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const finishButton = document.getElementById('finishButton');
            const purchaseForm = document.getElementById('purchaseForm');
            const formView = document.getElementById('formView');
            const thankYouView = document.getElementById('thankYouView');
            const submitButton = document.getElementById('submitButton');
            const formErrors = document.getElementById('formErrors');

            // Elemen di dalam Modal
            const modalItemTitle = document.getElementById('modalItemTitle');
            const modalItemPrice = document.getElementById('modalItemPrice');
            const hiddenGalleryId = document.getElementById('gallery_id');

            // Event listener untuk setiap item desain
            document.querySelectorAll('.design-item').forEach(item => {
                item.addEventListener('click', () => {
                    const { id, title, price, format, image } = item.dataset;
                    
                    document.getElementById('previewTitle').textContent = title;
                    document.getElementById('previewPrice').textContent = price;
                    document.getElementById('previewFormat').textContent = format;
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = image;
                    previewImage.classList.remove('hidden');
                    document.getElementById('previewPlaceholder').classList.add('hidden');

                    buyButton.disabled = false;
                    hiddenGalleryId.value = id; // Simpan ID ke input tersembunyi

                    item.classList.add('scale-95');
                    setTimeout(() => item.classList.remove('scale-95'), 150);
                });
            });

            // Fungsi untuk membuka modal
            const openModal = () => {
                modalItemTitle.textContent = document.getElementById('previewTitle').textContent;
                modalItemPrice.textContent = document.getElementById('previewPrice').textContent;

                purchaseModal.classList.remove('hidden');
                purchaseModal.classList.add('flex');

                formView.classList.remove('hidden');
                thankYouView.classList.add('hidden');
                formErrors.innerHTML = '';
                submitButton.disabled = false;
                submitButton.textContent = 'Submit';
                purchaseForm.reset(); // Reset form, tapi ID sudah diset saat klik
                 // Pastikan ID diset lagi saat modal dibuka, dari preview panel
                const activeItem = document.querySelector('.scale-95') || document.querySelector('.design-item'); // fallback
                if(hiddenGalleryId.value) {
                    // ID sudah ada dari klik terakhir, tidak perlu reset
                }
            };

            // Fungsi untuk menutup modal
            const closeModal = () => {
                purchaseModal.classList.add('hidden');
                purchaseModal.classList.remove('flex');
            };

            buyButton.addEventListener('click', () => {
                if (buyButton.disabled) return;
                openModal();
            });

            closeModalButton.addEventListener('click', closeModal);
            finishButton.addEventListener('click', closeModal);

            // LOGIKA SUBMIT FORM DENGAN AJAX (FETCH)
            purchaseForm.addEventListener('submit', function(event) {
                event.preventDefault();
                formErrors.innerHTML = '';

                const fileInput = document.getElementById('paymentProof');
                const file = fileInput && fileInput.files ? fileInput.files[0] : null;

                if (!file) {
                    formErrors.innerHTML = 'Please upload your payment proof image.';
                    return;
                }

                // Protect against server-side PHP upload limits (show friendly message)
                if (typeof SERVER_UPLOAD_MAX !== 'undefined' && file.size > SERVER_UPLOAD_MAX) {
                    const mb = Math.round(SERVER_UPLOAD_MAX / 1024 / 1024);
                    formErrors.innerHTML = `File too large. Server allows up to ${mb} MB. Please resize your image or contact the admin.`;
                    return;
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';

                const formData = new FormData(this);

                fetch("{{ route('gallery.adopt') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                    })
                    .then(async response => {
                        const json = await response.json().catch(() => null);
                        return { ok: response.ok, json };
                    })
                    .then(({ ok, json }) => {
                        if (ok && json && json.success) {
                            formView.classList.add('hidden');
                            thankYouView.classList.remove('hidden');
                        } else {
                            const errors = (json && json.errors) ? json.errors : { general: ['Failed to submit.'] };
                            let errorMessages = '<strong>Please fix the following errors:</strong><ul>';
                            for (const key in errors) {
                                errorMessages += `<li>- ${errors[key][0]}</li>`;
                            }
                            errorMessages += '</ul>';
                            formErrors.innerHTML = errorMessages;
                            submitButton.disabled = false;
                            submitButton.textContent = 'Submit';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        formErrors.innerHTML = 'An unexpected error occurred. Please try again.';
                        submitButton.disabled = false;
                        submitButton.textContent = 'Submit';
                    });
            });
        });
    </script>
@endsection
