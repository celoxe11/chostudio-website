<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cho Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
</head>

<body class="flex justify-center items-center min-h-screen py-4">
    <div
        class="flex flex-col justify-center items-center bg-[#f0ebe3] w-[95%] max-w-5xl min-h-[70%] p-8 rounded-3xl border-4 border-black">
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
                    <div class="space-y-4">
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="text" name="name" id="name" placeholder="Full Name" required>
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="text" name="username" id="username" placeholder="Username" required>
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="email" name="email" id="email" placeholder="Email Address" required>
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="password" name="password" id="password" placeholder="Password" required>
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Contact Information</h3>
                    <p class="text-sm text-center text-gray-600 mb-4">Please provide at least one contact method below</p>
                    
                    <div class="space-y-4">
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full contact-field" type="text" name="line_id" id="line_id" placeholder="Line ID (Optional)">
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full contact-field" type="tel" name="phone_number" id="phone_number" placeholder="Phone Number (Optional)">
                        <input class="bg-[#a2e1db] placeholder-[#477c77] placeholder:font-bold rounded-2xl p-4 text-base w-full contact-field" type="text" name="instagram" id="instagram" placeholder="Instagram Handle (Optional)">
                    </div>
                    
                    <div id="contact-error" class="text-red-600 text-sm text-center hidden">
                        Please provide at least one contact method (Line ID, Phone Number, or Instagram)
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <button type="submit" class="font-[HammersmithOne-Regular] bg-[#b4a6d5] w-full max-w-md py-4 text-xl rounded-2xl outline hover:bg-[#477c77] transition-colors duration-300 ease-in-out">Register</button>
            </div>
        </form>

        <div class="flex flex-col items-center gap-3 mt-6">
            <a href="/login"
                class="text-base font-semibold text-black hover:text-[#ffac81] transition-colors duration-300">
                Already have an account? Login here
            </a>
        </div>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const lineId = document.getElementById('line_id').value.trim();
            const phoneNumber = document.getElementById('phone_number').value.trim();
            const instagram = document.getElementById('instagram').value.trim();
            const errorDiv = document.getElementById('contact-error');
            
            // Check if at least one contact method is provided
            if (!lineId && !phoneNumber && !instagram) {
                e.preventDefault();
                errorDiv.classList.remove('hidden');
                
                // Add red border to contact fields
                document.querySelectorAll('.contact-field').forEach(field => {
                    field.classList.add('border-2', 'border-red-500');
                });
                
                // Scroll to error message
                errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                errorDiv.classList.add('hidden');
                
                // Remove red border from contact fields
                document.querySelectorAll('.contact-field').forEach(field => {
                    field.classList.remove('border-2', 'border-red-500');
                });
            }
        });
        
        // Remove error styling when user starts typing in contact fields
        document.querySelectorAll('.contact-field').forEach(field => {
            field.addEventListener('input', function() {
                const lineId = document.getElementById('line_id').value.trim();
                const phoneNumber = document.getElementById('phone_number').value.trim();
                const instagram = document.getElementById('instagram').value.trim();
                
                if (lineId || phoneNumber || instagram) {
                    document.getElementById('contact-error').classList.add('hidden');
                    document.querySelectorAll('.contact-field').forEach(f => {
                        f.classList.remove('border-2', 'border-red-500');
                    });
                }
            });
        });
    </script>
</body>

</html>
