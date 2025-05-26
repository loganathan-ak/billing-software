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
        
        <div class="flex justify-end">
            <form method='POST' action="/delete-customer">
                @csrf
                @method('DELETE')
                <input type="hidden" name="customer_id" value='{{$customerdata->id}}'/>
                <button type="submit"
                class="h-9  w-[120px] text-red-500 font-medium">
                Delete
                </button>
            </form>
            <div class="flex justify-end ">
                <a href="/customers" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                    ← Back
                </a>
            </div>
        </div>

        <form action="/update-customer" method="POST" class="grid gap-5 items-center p-3">
            @csrf
            @method('PUT')
        
            <input type="hidden" name="customer_id" value="{{ $customerdata->id }}">
        
            <!-- Customer Name -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="customer_name" class="text-sm font-medium text-gray-500 col-span-1">Customer Name*</label>
                <input
                    id="customer_name"
                    name="customer_name"
                    type="text"
                    value="{{ $customerdata->customer_name }}"
                    placeholder="Enter customer name"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                >
            </div>
        
            <!-- Address -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="address" class="text-sm font-medium text-gray-500 col-span-1">Address*</label>
                <input
                    id="address"
                    name="address"
                    type="text"
                    value="{{ $customerdata->address }}"
                    placeholder="Enter address"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                >
            </div>
        
            <!-- Contact Number -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="contact_number" class="text-sm font-medium text-gray-500 col-span-1">Contact Number*</label>
                <input
                    id="contact_number"
                    name="contact_number"
                    type="text"
                    value="{{ $customerdata->contact_number }}"
                    placeholder="Enter contact number"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                >
            </div>
        
            <!-- Email -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="email" class="text-sm font-medium text-gray-500 col-span-1">Email*</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ $customerdata->email }}"
                    placeholder="Enter email address"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                >
            </div>

                {{-- GST Checkbox and Number --}}
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <div class="flex md:gap-2 items-center">
                <label for="is_gst" class="text-sm font-medium text-gray-500 col-span-1">Is GST*</label>
                <input type="checkbox" name="is_gst" id="is_gst" class="h-4 w-4 text-blue-600 border-gray-300 rounded" {{ $customerdata->is_gst ? 'checked' : '' }}/>

                </div>
                <input type="text" name="gst_number" placeholder="Enter GST number"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"  value="{{ $customerdata->gst_number }}" {{ $customerdata->is_gst ? '' : 'readonly' }}/>
            </div>
        
            <!-- Description -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="description" class="text-sm font-medium text-gray-500 col-span-1">Description</label>
                <input
                    id="description"
                    name="description"
                    type="text"
                    value="{{ $customerdata->description }}"
                    placeholder="Enter description (optional)"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                >
            </div>
        
            <!-- Buttons -->
            <div class="flex gap-4 mt-4">
                <button type="submit" class="h-9 px-4 py-1 w-[120px] bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Save
                </button>
            </div>
        </form>
        



</x-pagestructure>
</x-layout>
