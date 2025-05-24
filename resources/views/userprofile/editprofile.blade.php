<x-layout> 
    <x-pagestructure>
        <div class="flex flex-1 flex-col gap-4 p-4">
            @if ($errors->any())
            <ul class="mb-4 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="flex justify-end ">
            <a href="{{route('userprofile')}}" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
            <form class="grid gap-5 items-center p-3" method='POST' action="{{ route('profile.update') }}">

                @csrf

                {{-- Vendor Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="name" class="text-sm font-medium text-gray-500">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter name"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->name }}" />
                </div>

                @if(Auth::user()->user_role === 'admin')

                {{-- Phone --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="phone" class="text-sm font-medium text-gray-500">Phone</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter contact number"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->contact_number }}" />
                </div>
                

                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="email" class="text-sm font-medium text-gray-500">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter email"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->email }}" />
                </div>

                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="company_name" class="text-sm font-medium text-gray-500">Company Name</label>
                    <input type="text" name="company_name" id="company_name" placeholder="Enter company name"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->company_name }}" />
                </div>

                {{-- Address --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="address" class="text-sm font-medium text-gray-500">Address</label>
                    <input type="text" name="address" id="address" placeholder="Enter address"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->address }}" />
                </div>
              
                {{-- GST Checkbox and Number --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="is_gst" class="text-sm font-medium text-gray-500 col-span-1">GST Number</label>
                    <input type="text" name="gst_number" placeholder="Enter GST number"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ $user->gst_number }}" />
                </div>
              @endif

                {{-- Buttons --}}
                <div class="flex gap-4 mt-4">
                    <button type="submit"
                        class="h-9 px-4 py-1 w-[120px] bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Update user
                    </button>
                </div>
            </form>
        </div>
    </x-pagestructure>
</x-layout>
