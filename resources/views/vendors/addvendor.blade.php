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
            <a href="/vendors" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
            <form class="grid gap-5 items-center p-3" method='POST' action="/add-vendor">

                @csrf

                {{-- Vendor Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="vendor_name" class="text-sm font-medium text-gray-500">Vendor Name*</label>
                    <input type="text" name="vendor_name" id="vendor_name" placeholder="Enter vendor name"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('vendor_name') }}" required/>
                </div>

                {{-- Contact Person --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="contact_person" class="text-sm font-medium text-gray-500">Contact Person*</label>
                    <input type="text" name="contact_person" id="contact_person" placeholder="Enter contact person name"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('contact_person') }}" required/>
                </div>

                {{-- Address --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="address" class="text-sm font-medium text-gray-500">Address*</label>
                    <input type="text" name="address" id="address" placeholder="Enter address"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('address') }}" required/>
                </div>

                {{-- Phone --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="phone" class="text-sm font-medium text-gray-500">Phone*</label>
                    <input type="text" name="phone" id="phone" placeholder="Enter contact number"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('phone') }}" required/>
                </div>

                {{-- GST Checkbox and Number --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <div class="flex md:gap-2 items-center">
                    <label for="is_gst" class="text-sm font-medium text-gray-500 col-span-1">Is GST*</label>
                    <input type="checkbox" name="is_gst" id="is_gst"
                        class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                    </div>
                    <input type="text" name="gst_number" placeholder="Enter GST number"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('gst_number') }}" readonly/>
                </div>

                {{-- Description --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="description" class="text-sm font-medium text-gray-500">Description (optional)</label>
                    <input type="text" name="description" id="description" placeholder="Enter description (optional)"
                        class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" value="{{ old('description') }}" />
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 mt-4">
                    <button type="submit"
                        class="h-9 px-4 py-1 w-[120px] bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </x-pagestructure>
</x-layout>
