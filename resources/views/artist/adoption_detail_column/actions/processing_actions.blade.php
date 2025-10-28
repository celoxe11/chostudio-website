{{-- file upload section --}}
<div class="overflow-hidden">

    <div class="space-y-4">
        <!-- Delivery Method Selection -->
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-5 rounded-xl border-2 border-indigo-200 shadow-md">
            <label class="text-sm font-bold text-indigo-700 mb-3 block">Choose Delivery Method:</label>
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <label
                    class="flex items-center gap-2 p-3 bg-white rounded-lg border-2 border-indigo-200 cursor-pointer hover:bg-indigo-50 transition-colors duration-200">
                    <input type="radio" name="delivery_method" value="upload" id="delivery_method_upload"
                        class="w-5 h-5 text-purple-600 focus:ring-purple-500" checked>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">Upload Files Directly</span>
                    </div>
                </label>

                <label
                    class="flex items-center gap-2 p-3 bg-white rounded-lg border-2 border-indigo-200 cursor-pointer hover:bg-indigo-50 transition-colors duration-200">
                    <input type="radio" name="delivery_method" value="link" id="delivery_method_link"
                        class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-800">Provide Download Link</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Upload Files Card -->
        <div id="upload-section"
            class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl border-2 border-purple-200 shadow-md">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <label class="text-sm font-bold text-purple-700">Upload Files</label>
            </div>

            <div
                class="border-2 border-dashed border-purple-300 rounded-lg p-4 bg-white hover:bg-purple-50 transition-colors duration-200">
                <input type="file" id="delivery_files" name="delivery_files[]" multiple class="hidden"
                    accept="image/*,.pdf,.zip,.rar,.psd,.ai,.eps">
                <label for="delivery_files" class="cursor-pointer flex flex-col items-center gap-2">
                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <span class="text-sm font-semibold text-purple-700">Click to upload files</span>
                    <span class="text-xs text-purple-600">or drag and drop</span>
                    <span class="text-xs text-gray-500 mt-1">PNG, JPG, PDF, ZIP, PSD, AI up to 100MB</span>
                </label>
            </div>

            <!-- File list preview (if files uploaded) -->
            <div id="file-list" class="mt-3 space-y-2 hidden">
                <!-- Files will be listed here via JavaScript -->
            </div>
        </div>

        <!-- Download Link Card -->
        <div id="link-section"
            class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border-2 border-blue-200 shadow-md hidden">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                    </path>
                </svg>
                <label class="text-sm font-bold text-blue-700">Provide Download Link</label>
            </div>

            <input type="url" id="download_link" name="download_link" value="{{ $adoption->download_link ?? '' }}"
                class="w-full px-4 py-3 border-2 border-blue-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 font-[HammersmithOne-Regular] text-sm"
                placeholder="https://drive.google.com/... or https://dropbox.com/...">

            <p class="text-xs text-blue-600 mt-2 flex items-center gap-1">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Provide a link to Google Drive, Dropbox, WeTransfer, or any file hosting service</span>
            </p>
        </div>

        <!-- Delivery Notes Section -->
        <div class="overflow-hidden">

            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 p-5 rounded-xl border-2 border-teal-200 shadow-md">
                <label class="block text-sm font-bold text-teal-700 mb-3">
                    Add notes about file delivery
                    <span class="text-xs font-normal text-teal-600 ml-2">(Optional)</span>
                </label>
                <textarea id="delivery_notes" name="delivery_notes" rows="6"
                    class="w-full px-4 py-3 border-2 border-teal-300 rounded-lg bg-white focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all duration-200 resize-none font-[HammersmithOne-Regular] text-sm"
                    placeholder="e.g., Files uploaded to Google Drive, Download link sent via email, Special instructions for the buyer...">{{ $adoption->delivery_notes }}</textarea>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-teal-600">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        These notes are for your reference
                    </span>
                    <button
                        class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 text-sm">
                        Save Notes
                    </button>
                </div>
            </div>
        </div>


        <!-- Send Delivery Email Button -->
        <button type="button" id="send-delivery-email-btn" data-adoption-id="{{ $adoption->adoption_id }}"
            class="w-full px-6 py-4 rounded-xl border-2 border-emerald-600 bg-emerald-600 text-white font-bold shadow-lg hover:shadow-xl hover:bg-emerald-700 hover:border-emerald-700 hover:-translate-y-1 transform transition-all duration-300 ease-out">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Send File Links to Buyer (via Email)
            </div>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadRadio = document.getElementById('delivery_method_upload');
            const linkRadio = document.getElementById('delivery_method_link');
            const uploadSection = document.getElementById('upload-section');
            const linkSection = document.getElementById('link-section');

            function toggleSections() {
                if (uploadRadio.checked) {
                    uploadSection.classList.remove('hidden');
                    linkSection.classList.add('hidden');
                } else {
                    uploadSection.classList.add('hidden');
                    linkSection.classList.remove('hidden');
                }
            }

            uploadRadio.addEventListener('change', toggleSections);
            linkRadio.addEventListener('change', toggleSections);
        });
    </script>
</div>
