@extends('template')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div
            class="flex flex-col relative justify-center items-center bg-[#f0ebe3] w-[95%] md:w-[85%] lg:w-[80%] h-[80%] p-8 rounded-3xl border-4 border-black">
            {{-- Back to home --}}
            <div class="absolute top-10 left-10 w-full flex justify-start mb-4">
                <a href={{ route('home') }}
                    class="font-[HammersmithOne-Regular] bg-[#a2e1db] hover:bg-[#b4a6d5] transition-colors duration-300 ease-in-out text-sm sm:text-base px-4 py-2 rounded-2xl border-4 border-black">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>

            {{-- judul --}}
            <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
                <h1 class="text-3xl md:text-5xl lg:text-5xl">Register</h1>
            </div>

            <form class="w-full max-w-4xl" action="" method="post" id="registerForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">Basic Information</h3>
                        <p class="text-sm text-center text-gray-600 mb-4">Please provide your basic details below
                        </p>
                        <div class="space-y-4">
                            <input
                                class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                                type="text" name="name" id="name" placeholder="Full Name" required>
                            <input
                                class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                                type="text" name="username" id="username" placeholder="Username" required>
                            <input
                                class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                                type="email" name="email" id="email" placeholder="Email Address" required>
                            <input
                                class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                                type="password" name="password" id="password" placeholder="Password" required>
                            <input
                                class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full"
                                type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm Password" required>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-4">
                        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">Contact Information</h3>
                        <p class="text-sm text-center text-gray-600 mb-4">Please provide at least one contact method below
                        </p>

                        <div class="space-y-4">
                            {{-- Added checkbox for Line ID with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_line_id" id="has_line_id"
                                        class="w-5 h-5 rounded border-2 border-black accent-[#a2e1db]">
                                    <span class="text-base font-semibold text-gray-800">Line ID</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full hidden contact-field"
                                    type="text" name="line_id" id="line_id" placeholder="Enter your Line ID">
                            </div>

                            {{-- Added checkbox for Phone Number with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_phone" id="has_phone"
                                        class="w-5 h-5 rounded border-2 border-black accent-[#a2e1db]">
                                    <span class="text-base font-semibold text-gray-800">Phone Number</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full hidden contact-field"
                                    type="tel" name="phone_number" id="phone_number"
                                    placeholder="Enter your phone number">
                            </div>

                            {{-- Added checkbox for Instagram with show/hide functionality --}}
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="checkbox" name="has_instagram" id="has_instagram"
                                        class="w-5 h-5 rounded border-2 border-black accent-[#a2e1db]">
                                    <span class="text-base font-semibold text-gray-800">Instagram</span>
                                </label>
                                <input
                                    class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full hidden contact-field"
                                    type="text" name="instagram" id="instagram"
                                    placeholder="Enter your Instagram handle">
                            </div>
                        </div>

                        <div id="contact-error" class="text-red-600 text-sm text-center hidden">
                            Please provide at least one contact method (Line ID, Phone Number, or Instagram)
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full max-w-md py-4 text-xl rounded-2xl outline hover:bg-[#477c77] transition-colors duration-300 ease-in-out">Register</button>
                </div>
            </form>

            <div class="flex flex-col items-center gap-3 mt-6">
                <a href="/login"
                    class="text-base font-semibold text-black hover:text-[#ffac81] transition-colors duration-300">
                    Already have an account? Login here
                </a>
            </div>
        </div>
    </div>

    {{-- Added JavaScript to handle checkbox toggle and form validation --}}
    <script>
        $(function () {
            const $lineIdCheckbox = $('#has_line_id');
            const $phoneCheckbox = $('#has_phone');
            const $instagramCheckbox = $('#has_instagram');

            const $lineIdInput = $('#line_id');
            const $phoneInput = $('#phone_number');
            const $instagramInput = $('#instagram');

            const $contactError = $('#contact-error');
            const $registerForm = $('#registerForm');

            $lineIdCheckbox.on('change', function () {
                $lineIdInput.toggleClass('hidden');
                if (!this.checked) $lineIdInput.val('');
                $contactError.addClass('hidden');
            });

            $phoneCheckbox.on('change', function () {
                $phoneInput.toggleClass('hidden');
                if (!this.checked) $phoneInput.val('');
                $contactError.addClass('hidden');
            });

            $instagramCheckbox.on('change', function () {
                $instagramInput.toggleClass('hidden');
                if (!this.checked) $instagramInput.val('');
                $contactError.addClass('hidden');
            });

            $registerForm.on('submit', function (e) {
                const hasLineId = $lineIdCheckbox.is(':checked') && $.trim($lineIdInput.val()) !== '';
                const hasPhone = $phoneCheckbox.is(':checked') && $.trim($phoneInput.val()) !== '';
                const hasInstagram = $instagramCheckbox.is(':checked') && $.trim($instagramInput.val()) !== '';

                if (!hasLineId && !hasPhone && !hasInstagram) {
                    e.preventDefault();
                    $contactError.removeClass('hidden');
                }
            });
        });
    </script>
@endsection
