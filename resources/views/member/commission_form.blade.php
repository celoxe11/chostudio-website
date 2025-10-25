@extends('member.member_template')

@section('content')
    <div class="flex justify-center h-full overflow-hidden ">
        <div
            class="flex justify-center bg-[#f0ebe3] border-4 border-black h-[70%] w-[80%] overflow-hidden m-10 rounded-2xl shadow-md">
            <div class="flex flex-row items-center h-full w-full p-10">
                {{-- image section --}}
                @php
                    // safe defaults
                    $category = $category ?? null;
                    $imgPath = asset('assets/images/sample.jpeg');
                    if ($category === 'Head Shot') {
                        $imgPath = asset('assets/images/sample.jpeg');
                    } elseif ($category === 'Half Body') {
                        $imgPath = asset('assets/images/sample.jpeg');
                    } elseif ($category === 'Full Body') {
                        $imgPath = asset('assets/images/sample.jpeg');
                    } elseif ($category === 'Custom') {
                        $imgPath = asset('assets/images/sample.jpeg');
                    }
                @endphp

                {{-- Form section --}}
                <div class="flex flex-col justify-center items-center w-full h-full">
                <img src="{{ $imgPath }}" alt="{{ $category ?? 'Sample' }}"
                        class="object-cover w-[60%] h-[95%] rounded-xl border-3 border-black">
                    <p class="mt-2 font-[HammersmithOne-Regular] text-[1rem]">{{ $category ?? 'No selection' }}</p>
                </div>
                <div class="flex flex-col justify-center items-center w-[90%] form-container rounded-t-3xl bg-white border-t-3 border-x-3 border-black p-5 mt-10">
                        <h2 class="text-2xl mb-2 font-[HammersmithOne-Regular] flex justify-center">
                            Commission Form
                        </h2>
                        <form class="flex flex-col w-[90%] gap-4" method="post"
                            action="{{ route('member.commission_form') }}">
                            @csrf
                            <!-- carry category into submission -->
                            <input type="hidden" name="category" value="{{ $category ?? '' }}">
                            <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Name
                                    :</label> <input type="text" placeholder="Name"
                                    class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                            </div>
                            <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Email
                                    :</label> <input type="email" placeholder="Email"
                                    class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                            </div>
                            <div class="flex justify-between items-center"> <label
                                    class="font-[HammersmithOne-Regular] text-left">Whatsapp (Active) :</label> <input
                                    type="text" placeholder="WhatsApp Number"
                                    class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                            </div>
                            <div class="flex justify-between items-start"> <label
                                    class="font-[HammersmithOne-Regular] mt-1">Detail Art :</label>
                                <textarea rows="3" placeholder="Describe your commission"
                                    class="border-3 border-[#b4a6d5] text-[#b4a6d5] rounded-md px-2 py-1 w-[70%] resize-none focus:outline-none focus:border-[#a27fe1]"></textarea>
                            </div>
                            <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Price
                                    :</label> <button type="submit"
                                    class="bg-[#f3a77e] border-3 border-black rounded-md px-4 py-1 font-[HammersmithOne-Regular] hover:bg-[#e48d5f] transition duration-200">
                                    Submit </button> </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
