@extends('template')

@section('content')
    <div
        class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start bg-[url('/assets/images/bg2.png')] bg-cover bg-no-repeat">
        <div class="container w-full sm:w-[95%] lg:w-[80%]">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 sm:gap-0">
                
                <div
                    class="bg-[#f0ebe3] rounded-t-3xl h-full py-4 sm:py-6 px-8 sm:px-20 shadow-[1.2vh_0_black] sm-h-full order-2 sm:order-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-5xl text-bold font-[HammersmithOne-Regular]">Cho's
                        Studio
                    </h1>
                </div>
                <div class="flex h-full order-1 sm:order-2 overflow-visible max-sm:gap-3 max-sm:justify-center">

                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Home</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Gallery</button>
                    </div>
                    <div
                        class="font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-l-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap">
                        <button>Shop</button>
                    </div>
                    <div class="relative inline-block">
                         <div
                            class="absolute translate-x-5.5 translate-y-6 bg-black rounded-t-2xl h-full w-full z-[-1]">
                        </div>

                        <div
                            class="relative font-[HammersmithOne-Regular] bg-[#a2e1db] h-full py-3 sm:py-4 px-4 sm:px-8 max-sm:border-2 max-sm:rounded-xl rounded-t-2xl border-t-4 border-x-4 border-black hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-lg whitespace-nowrap z-10">
                            <button>Member</button>
                        </div>
                    </div>

                    
                </div>
            </div>

            <!-- GALERI ART TIDAK UNTUK DIJUAL -->
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
                        <div
                            class="col-span-2 row-span-2 bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
                        </div>
                        <div
                            class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
                        </div>
                        <div
                            class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
                        </div>
                        <div
                            class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
                        </div>
                        <div
                            class="bg-gradient-to-b from-sky-200 to-green-300 rounded-xl outline-2 outline-black shadow-[0.5vh_0.5vh_0_black]">
                        </div>
                    </div>
                    <div>
                    <div>

                    </div>
                </div>
                </div>
                
            </div>

            <!-- SECTION READY TO BUY -->
            <section id="readyToBuy"
                class="mt-12 bg-[#f0ebe3] rounded-3xl border-4 border-black shadow-[3vh_3vh_0_black] p-6 sm:p-10">
                <h2 class="font-[HammersmithOne-Regular] text-2xl sm:text-3xl text-center mb-6">
                    READY-TO-BUY DESIGNS
                </h2>

                <div class="flex flex-col sm:flex-row gap-6">
                    <!-- LEFT: PREVIEW -->
                    <div id="previewPanel"
                    class="flex-1 bg-white border-4 border-black rounded-2xl shadow-[0.6vh_0.6vh_0_black] p-4 flex flex-col items-center justify-between
                        w-full sm:w-[30vw] sm:min-w-[300px] transition-all duration-300">
                    <h3 id="previewTitle"
                        class="font-[HammersmithOne-Regular] text-xl sm:text-2xl mb-3 text-center">Select a Design</h3>

                    <div class="w-full aspect-square bg-[#dceef4] rounded-xl overflow-hidden flex justify-center items-center">
                        <img id="previewImage" src="" alt="Preview" class="object-cover hidden w-full h-full">
                        <p id="previewPlaceholder" class="text-gray-500">Click an image to preview</p>
                    </div>

                    <div class="w-full mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                            <span id="previewFormat"
                                class="px-3 py-1 bg-green-200 border border-black rounded-full text-sm font-semibold">-</span>
                            <span class="text-sm sm:text-lg font-semibold">Price:
                                <span id="previewPrice">-</span></span>
                        </div>
                        <button id="buyButton" disabled
                            class="bg-[#4c9eff] border-4 border-black px-6 py-2 rounded-xl font-[HammersmithOne-Regular] 
                            hover:bg-[#73b7ff] transition duration-300 w-full sm:w-auto 
                            disabled:opacity-50 disabled:cursor-not-allowed">
                            Buy Now
                        </button>
                    </div>

                </div>


                    <!-- RIGHT: GRID -->
                    <div id="designGrid" class="grid grid-cols-3 sm:grid-cols-4  gap-2 flex-1 h-fit transition-all duration-300">
                            <div class="design-item cursor-pointer bg-gradient-to-b from-yellow-100 to-orange-200 border-2 border-black rounded-md shadow-[0.4vh_0.4vh_0_black] h-fit"
                            data-title="Crimson Sky" data-price="Rp 270.000" data-format="PNG"
                            data-image="https://i.pinimg.com/1200x/12/9c/f4/129cf464f43f242801bf746de3a78a48.jpg">
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script>
        const designs = [
            {
                title: "Crimson Sky",
                price: "Rp 270.000",
                format: "PNG",
                image: "https://i.pinimg.com/1200x/20/79/25/2079253ad6c3d70f2c03c95cbd5d074a.jpg"
            },
            {
                title: "Azure Horizon",
                price: "Rp 300.000",
                format: "JPG",
                image: "https://i.pinimg.com/736x/df/d0/9e/dfd09ef4bdf9be5d4c107735845541bb.jpg"
            },
            {
                title: "Golden Bloom",
                price: "Rp 250.000",
                format: "PNG",
                image: "https://i.pinimg.com/736x/79/d0/ca/79d0cae8bc9914c7271ec52caf857e9b.jpg"
            },
            {
                title: "Midnight Dream",
                price: "Rp 290.000",
                format: "SVG",
                image: "https://i.pinimg.com/1200x/1f/7e/cd/1f7ecd773b72df9587a6e3440f7f23bb.jpg"
            },
            {
                title: "Lush Garden",
                price: "Rp 310.000",
                format: "PNG",
                image: "https://i.pinimg.com/1200x/51/a1/c5/51a1c5033466b0c5f82b8a37e1fcf03b.jpg"
            }
        ];

        const container = document.getElementById("designGrid");

        // Generate elemen HTML dari data
        container.innerHTML = designs.map(design => `
            <div 
                class="design-item cursor-pointer bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200"
                data-title="${design.title}" 
                data-price="${design.price}" 
                data-format="${design.format}" 
                data-image="${design.image}"
            >
                <img src="${design.image}" alt="${design.title}" class="w-full h-full object-cover rounded-sm border-2 border-black">
            </div>
        `).join('');

        // Event listener klik untuk preview
        const buyButton = document.getElementById('buyButton');

        // Event listener klik untuk preview
        document.querySelectorAll('.design-item').forEach(item => {
            item.addEventListener('click', () => {
                const { title, price, format, image } = item.dataset;
                document.getElementById('previewTitle').textContent = title;
                document.getElementById('previewPrice').textContent = price;
                document.getElementById('previewFormat').textContent = format;
                document.getElementById('previewImage').src = image;
                document.getElementById('previewImage').classList.remove('hidden');
                document.getElementById('previewPlaceholder').classList.add('hidden');

                // ✅ Aktifkan tombol Buy setelah memilih gambar
                buyButton.disabled = false;

                // Tambah efek animasi klik
                item.classList.add('scale-95');
                setTimeout(() => item.classList.remove('scale-95'), 150);
            });
        });


        buyButton.addEventListener('click', () => {
            if (buyButton.disabled) return; // cegah klik saat belum aktif
            const title = document.getElementById('previewTitle').textContent;
            alert(`You are buying: ${title}`);
        });
    </script>


@endsection
