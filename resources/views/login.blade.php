@extends('template')

@section('content')
    <style>
        /* Prevent browser autofill from changing background color */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #a2e1db inset !important;
            -webkit-text-fill-color: #000 !important;
        }

        /* For other browsers */
        input:autofill {
            background-color: #a2e1db !important;
        }
    </style>

    <div class="flex justify-center items-center min-h-screen py-8">
        <div
            class="flex flex-col relative justify-center items-center bg-[#f0ebe3] w-[95%] md:w-[85%] lg:w-[80%] min-h-[90vh] sm:min-h-[85vh] md:min-h-[80vh] p-4 sm:p-6 md:p-8 rounded-3xl border-4 border-black">
            {{-- Back to home --}}
            <div class="absolute top-4 left-4 sm:top-10 sm:left-10 w-full flex justify-start mb-4">
                <a href={{ route('home') }}
                    class="flex items-center gap-2 font-[HammersmithOne-Regular] bg-[#a2e1db] hover:bg-[#477c77] transition-colors duration-300 ease-in-out text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2 rounded-2xl border-2 sm:border-4 border-black">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span class="hidden sm:inline">Back to Home</span>
                </a>
            </div>

            {{-- judul --}}
            <div class="flex justify-center mb-6 font-[HammersmithOne-Regular] mt-[5vh]">
                <h1 class="text-3xl md:text-5xl lg:text-5xl">LOGIN</h1>
            </div>

            <form class="flex flex-col items-center gap-4 w-full max-w-md" action="{{ route('process_login') }}"
                method="post" id="loginForm">
                @csrf
                <input
                    class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                    type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                <input
                    class="bg-[#a2e1db] placeholder-[#477c77] font-[HammersmithOne-Regular] rounded-2xl p-4 text-base w-full focus:outline-none focus:ring-4 focus:ring-[#477c77] focus:border-transparent transition-all duration-200"
                    type="password" name="password" id="password" placeholder="Password">
                <button type="submit"
                    class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full py-4 text-xl rounded-2xl border-3 border-black hover:bg-[#8b7db8] focus:outline-none focus:ring-4 focus:ring-[#ffac81] transition-colors duration-300 ease-in-out">Login</button>
            </form>

            <div class="flex flex-col items-center gap-3 mt-6">
                <a href="/register"
                    class="text-base font-semibold text-black hover:text-[#ffac81] transition-colors duration-300 md:text-lg lg:text-xl">
                    Don't have an account? Register here
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="module">
        const $ = window.jQuery || window.$;

        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                // check if credentials are filled
                const username = $('#username').val().trim();
                const password = $('#password').val().trim();

                if (username === '' || password === '') {
                    notie.alert({
                        type: 'error', // Tipe error (merah)
                        text: 'Please fill in both username and password.',
                        time: 5,
                    });
                    return;
                }

                const form = $(this);
                const actionUrl = form.attr('action');
                // Ambil semua data form, termasuk token CSRF
                let formData = form.serialize();

                // Secara opsional, tambahkan token CSRF secara eksplisit (redundant jika .serialize() bekerja)
                // Ini adalah langkah pengamanan tambahan:
                const csrfToken = form.find('input[name="_token"]').val();
                if (csrfToken && formData.indexOf('_token=') === -1) {
                    formData += '&_token=' + csrfToken;
                }

                const submitButton = form.find('button[type="submit"]');

                // Disable the submit button to prevent multiple clicks
                submitButton.prop('disabled', true).text('Logging in...');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json', // Pastikan mengharapkan JSON dari server

                    success: function(response) {
                        console.log(response);

                        // Response JSON sukses (success: true)
                        submitButton.prop('disabled', false).text('Login');
                        if (response.success) {
                            notie.alert({
                                type: 'success', // Tipe sukses (hijau)
                                text: response.message,
                                time: 2,
                            });

                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 500);
                        } else {
                            notie.alert({
                                type: 'error', // Tipe error (merah)
                                text: response.message,
                                time: 5,
                            });
                        }
                    },
                    error: function(xhr) {
                        // Response gagal (status 422, 500, dll.)
                        submitButton.prop('disabled', false).text('Login');
                        let errorMessage = 'Unexpected Error Occured.';

                        try {
                            const response = xhr.responseJSON;

                            if (xhr.status === 422) {
                                // 1. Kegagalan Otentikasi (Custom Controller Error)
                                if (response && response.message) {
                                    errorMessage = response.message;
                                }
                                // 2. Kegagalan Validasi Laravel (Default Error Structure)
                                else if (response && response.errors) {
                                    // Ambil pesan error pertama dari semua field
                                    const firstErrorField = Object.keys(response.errors)[0];
                                    errorMessage = response.errors[firstErrorField][0];
                                }
                            } else {
                                errorMessage = response.message ||
                                    'Server Error. Please try again later.';
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }

                        // Tampilkan notifikasi error menggunakan notie
                        notie.alert({
                            type: 'error', // Tipe error (merah)
                            text: errorMessage,
                            time: 10,
                        });
                    }
                });
            });
        });
    </script>
@endsection
