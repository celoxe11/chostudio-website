@extends('member.member_template')

@section('content')
    <div class="flex justify-center h-full overflow-hidden ">
        <div
            class="flex justify-center items-center bg-[#f0ebe3] border-4 border-black h-[70%] w-[70%] overflow-hidden m-10 rounded-2xl shadow-md">
            <div class="flex flex-row items-center">
                {{-- image section --}}
                <div
                    class="flex flex-col justify-center items-center w-[30%] h-full"> <img
                        src="{{ asset('assets/images/sample.jpeg') }}" alt="Head Shot"
                        class="object-cover w-[80%] h-[80%] rounded-xl border-2 border-black">
                    <p class="mt-2 font-[HammersmithOne-Regular] text-[1rem]">Head Shot</p>
                </div>
                {{-- Form section --}}
                <div class="flex flex-col justify-center items-center w-[70%] h-full">
                    <h2 class="text-2xl font-bold mb-6 font-[HammersmithOne-Regular]">Commission Form</h2>
                    <form class="flex flex-col w-[80%] gap-4">
                        <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Name
                                :</label> <input type="text" placeholder="Name"
                                class="border-2 border-[#b8a2e1] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                        </div>
                        <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Email
                                :</label> <input type="email" placeholder="Email"
                                class="border-2 border-[#b8a2e1] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                        </div>
                        <div class="flex justify-between items-center"> <label
                                class="font-[HammersmithOne-Regular] text-left">Whatsapp (Active) :</label> <input
                                type="text" placeholder="WhatsApp Number"
                                class="border-2 border-[#b8a2e1] rounded-md px-2 py-1 w-[70%] focus:outline-none focus:border-[#a27fe1]" />
                        </div>
                        <div class="flex justify-between items-start"> <label
                                class="font-[HammersmithOne-Regular] mt-1">Detail Art :</label>
                            <textarea rows="3" placeholder="Describe your commission"
                                class="border-2 border-[#b8a2e1] rounded-md px-2 py-1 w-[70%] resize-none focus:outline-none focus:border-[#a27fe1]"></textarea>
                        </div>
                        <div class="flex justify-between items-center"> <label class="font-[HammersmithOne-Regular]">Price
                                :</label> <button type="submit"
                                class="bg-[#f3a77e] border-2 border-black rounded-md px-4 py-1 font-[HammersmithOne-Regular] hover:bg-[#e48d5f] transition duration-200">
                                Submit </button> </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
