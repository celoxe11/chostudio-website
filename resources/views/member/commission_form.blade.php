@extends('member.member_template')

@section('content')

<div class="flex justify-center h-full overflow-hidden">
    <div
        class="flex justify-center bg-[#f0ebe3] border-4 border-black h-[70%] w-[80%] overflow-hidden m-10 rounded-2xl shadow-md">
        <div class="flex flex-row items-center h-full w-full p-10">

        {{-- Left Image --}}
        @php
            $imgPath = match($category ?? '') {
                'Head Shot' => asset('assets/images/sample.jpeg'),
                'Half Body' => asset('assets/images/sample.jpeg'),
                'Full Body' => asset('assets/images/sample.jpeg'),
                'Custom' => asset('assets/images/sample.jpeg'),
                default => asset('assets/images/sample.jpeg'),
            };
        @endphp

        <div class="flex flex-col justify-center items-center w-[40%] h-full">
            <img src="{{ $imgPath }}" alt="{{ $category ?? 'Sample' }}"
                class="object-cover w-[70%] h-[80%] rounded-xl border-3 border-black">
            <p class="mt-2 font-[HammersmithOne-Regular] text-[1rem]">{{ $category ?? 'No selection' }}</p>
        </div>

        {{-- Right Form --}}
        <div class="flex flex-col justify-center items-center w-[60%] h-full bg-white border-l-4 border-black p-5">
            <h2 class="text-2xl mb-2 font-[HammersmithOne-Regular] flex justify-center">Commission Form</h2>
            <form class="flex flex-col w-[90%] gap-4" method="post"
                action="{{ route('member.commission_store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category ?? '' }}">

                <div class="flex justify-between items-start">
                    <label class="font-[HammersmithOne-Regular] mt-1">Detail Art :</label>
                    <textarea name="description" rows="3" placeholder="Describe your commission"
                        class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] resize-none focus:outline-none focus:border-[#a27fe1]" required></textarea>
                </div>

                <div class="flex justify-between items-center">
                    <label class="font-[HammersmithOne-Regular]">Deadline :</label>
                    <input type="date" name="deadline"
                        min="{{ \Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d') }}"
                        class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" required>
                </div>

                <div class="flex justify-between items-center">
                    <label class="font-[HammersmithOne-Regular]">Reference Image (optional) :</label>
                    <input type="file" name="image" accept="image/*"
                        class="border-3 border-[#b4a6d5] rounded-md px-2 py-1 w-[70%] text-sm">
                </div>

                <div class="flex justify-between items-center">
                    <label class="font-[HammersmithOne-Regular]">Price :</label>
                    <input type="number" name="price" placeholder="Price in IDR"
                        class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" required>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-[#f3a77e] border-3 border-black rounded-md px-6 py-2 font-[HammersmithOne-Regular] hover:bg-[#e48d5f] transition duration-200">
                        Submit
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

</div>
@endsection
