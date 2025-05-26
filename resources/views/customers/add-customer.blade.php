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
            <a href="/customers" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
        

<form action="/add-customer" class="grid gap-5 items-center p-3" method='POST'>
    @csrf

    <!-- Customer Name -->
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <label for="customer_name" class="text-sm font-medium text-gray-500 col-span-1">Customer Name*</label>
        <input
            id="customer_name"
            name="customer_name"
            type="text"
            value="{{ old('customer_name') }}"
            placeholder="Enter customer name"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
            required
        >
    </div>

    <!-- Address -->
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <label for="address" class="text-sm font-medium text-gray-500 col-span-1">Address*</label>
        <input
            id="address"
            name="address"
            type="text"
            value="{{ old('address') }}"
            placeholder="Enter address"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
            required
        >
    </div>

    <!-- Contact Number -->
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <label for="contact_number" class="text-sm font-medium text-gray-500 col-span-1">Contact Number*</label>
        <input
            id="contact_number"
            name="contact_number"
            type="text"
            value="{{ old('contact_number') }}"
            placeholder="Enter contact number"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
            required
        >
    </div>

    <!-- Email -->
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <label for="email" class="text-sm font-medium text-gray-500 col-span-1">Email*</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            placeholder="Enter email address"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
            required
        >
    </div>


    {{-- GST Checkbox and Number --}}
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <div class="flex md:gap-2 items-center">
        <label for="is_gst" class="text-sm font-medium text-gray-500 col-span-1">Is GST*</label>
        <input type="checkbox" name="is_gst" id="is_gst"
            class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
        </div>
        <input type="text" name="gst_number" placeholder="Enter GST number"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2" readonly/>
    </div>

    <!-- Description -->
    <div class="grid md:grid-cols-6 md:gap-2 items-center">
        <label for="description" class="text-sm font-medium text-gray-500 col-span-1">Description</label>
        <input
            id="description"
            name="description"
            type="text"
            value="{{ old('description') }}"
            placeholder="Enter description (optional)"
            class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
        >
    </div>

    <!-- Buttons -->
    <div class="flex gap-4 mt-4">
        <button type="submit" class="h-9 px-4 py-1 w-[120px] bg-blue-500 text-white rounded-md hover:bg-blue-600">
            Add
        </button>
    </div>
</form>



</x-pagestructure>
</x-layout>
