@extends('artist.artist_template')

@section('content')
<div class="flex justify-center items-center h-screen overflow-hidden">
    <div class="flex w-[85vw] h-[90vh] bg-[#f0ebe3] outline-4 rounded-2xl overflow-hidden font-[HammersmithOne-Regular]">

        <!-- LEFT: Upload Form -->
        <div class="w-[45%] bg-[#f0ebe3] p-6 flex flex-col justify-start items-start">
            <p class="text-lg mb-2">Picture preview :</p>

            <!-- Upload & Preview -->
            <div 
                id="previewBox" 
                class="bg-[#848484] text-white flex items-center justify-center w-40 h-40 mb-3 rounded cursor-pointer relative overflow-hidden hover:opacity-90 transition"
            >
                <span id="addText">Add Image</span>
                <input type="file" id="imageInput" accept="image/*" class="hidden">
                <img id="previewImage" class="absolute inset-0 w-full h-full object-cover hidden" alt="Preview">
                <button id="removeImageBtn" class="absolute top-1 right-1 bg-black/60 text-white text-xs px-2 py-1 rounded hidden hover:bg-black transition">
                    ✕
                </button>
            </div>

            <!-- Form Inputs -->
            <label class="text-sm flex items-center gap-2 mb-3">
                Enable Purchase? 
                <input id="purchaseCheckbox" type="checkbox" class="w-4 h-4 accent-[#f6a88a]">
            </label>

            <input id="titleInput" type="text" placeholder="Insert Title..." class="border rounded-lg px-3 py-2 mb-3 w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none">
            <textarea id="descInput" placeholder="Description" class="border rounded-lg px-3 py-2 mb-3 w-[80%] h-[80px] resize-none focus:ring-2 focus:ring-[#c9b8e3] outline-none"></textarea>
            <input id="priceInput" type="text" placeholder="Price" class="border rounded-lg px-3 py-2 mb-4 w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none">

            <select id="fileTypeInput" name="file_type" class="border rounded-lg px-3 py-2 mb-4 w-[80%] focus:ring-2 focus:ring-[#c9b8e3] outline-none">
                <option value="">-- Select File Type --</option>

                <optgroup label="🎨 Digital Illustration">
                    <option value="psd">PSD (Photoshop)</option>
                    <option value="csp">CSP (Clip Studio Paint)</option>
                    <option value="sai">SAI (Paint Tool SAI)</option>
                    <option value="png">PNG (Transparent Image)</option>
                    <option value="jpg">JPG / JPEG (Compressed Image)</option>
                    <option value="pdf">PDF (Artbook / Compilation)</option>
                </optgroup>
            </select>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <button id="submitBtn" class="bg-[#f6a88a] rounded-lg px-5 py-2 w-[100px] hover:bg-[#f58b6e] transition">
                    Add
                </button>
                <button id="deleteBtn" class="bg-red-400 rounded-lg px-5 py-2 w-[100px] hover:bg-red-500 transition hidden">
                    Delete
                </button>
            </div>
        </div>

        <!-- RIGHT: Gallery -->
        <div class="w-[55%] bg-[#c9b8e3] rounded-tr-2xl p-6 overflow-y-auto no-scrollbar">
            <div id="galleryGrid" class="grid grid-cols-3 sm:grid-cols-4  gap-4 flex-1 h-fit transition-all duration-300">
                @foreach ($galleryData as $index => $item)
                    <div 
                        class="design-item cursor-pointer bg-gradient-to-b from-yellow-100 to-orange-200 rounded-md shadow-[0.4vh_0.4vh_0_black] hover:shadow-[0.6vh_0.6vh_0_black] hover:-translate-y-[0.3vh] transition-all duration-200"
                        data-index="{{ $index }}"
                        data-image="{{ $item['image_url'] }}"
                        data-title="{{ $item['title'] ?? '' }}"
                        data-desc="{{ $item['description'] ?? '' }}"
                        data-price="{{ $item['price'] ?? '' }}"
                        data-file="{{ $item['file_type'] ?? '' }}"
                        data-purchase="{{ $item['purchase'] ?? false }}"
                    >
                        <img src="{{ $item['image_url'] }}" alt="Image" class="rounded-md object-cover w-40 h-40 border-2 border-black ">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Script: Upload + Edit/Delete Mode -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const previewBox = document.getElementById('previewBox');
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const addText = document.getElementById('addText');
    const removeBtn = document.getElementById('removeImageBtn');
    const submitBtn = document.getElementById('submitBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const galleryGrid = document.getElementById('galleryGrid');

    const titleInput = document.getElementById('titleInput');
    const descInput = document.getElementById('descInput');
    const priceInput = document.getElementById('priceInput');
    const fileTypeInput = document.getElementById('fileTypeInput');
    const purchaseCheckbox = document.getElementById('purchaseCheckbox');

    let editMode = false;
    let currentIndex = null;

    // Upload Preview
    previewBox.addEventListener('click', () => imageInput.click());
    imageInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e2) => {
            previewImage.src = e2.target.result;
            previewImage.classList.remove('hidden');
            addText.classList.add('hidden');
            removeBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });

    removeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        resetImagePreview();
    });

    function resetImagePreview() {
        previewImage.src = '';
        previewImage.classList.add('hidden');
        addText.classList.remove('hidden');
        removeBtn.classList.add('hidden');
        imageInput.value = '';
    }

    // Klik gambar untuk Edit Mode
    galleryGrid.addEventListener('click', (e) => {
        const card = e.target.closest('[data-index]');
        if (!card) return;

        editMode = true;
        currentIndex = card.dataset.index;

        // Isi form dari data
        previewImage.src = card.dataset.image;
        previewImage.classList.remove('hidden');
        addText.classList.add('hidden');
        removeBtn.classList.remove('hidden');
        titleInput.value = card.dataset.title;
        descInput.value = card.dataset.desc;
        priceInput.value = card.dataset.price;
        fileTypeInput.value = card.dataset.file.toLowerCase();
        purchaseCheckbox.checked = (card.dataset.purchase === 'true');

        // Ganti tombol
        submitBtn.textContent = 'Update';
        deleteBtn.classList.remove('hidden');
    });

    // Tombol Delete
    deleteBtn.addEventListener('click', () => {
        if (!editMode) return;
        alert(`Deleted item index ${currentIndex}`);
        resetForm();
    });

    // Tombol Add/Update
    submitBtn.addEventListener('click', () => {
        if (editMode) {
            alert(`Updated item index ${currentIndex}`);
        } else {
            alert('Added new artwork!');
        }
        resetForm();
    });

    function resetForm() {
        editMode = false;
        currentIndex = null;
        titleInput.value = '';
        descInput.value = '';
        priceInput.value = '';
        fileTypeInput.value = '';
        purchaseCheckbox.checked = false;
        resetImagePreview();
        submitBtn.textContent = 'Add';
        deleteBtn.classList.add('hidden');
    }
});
</script>
@endsection


