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
                <form method='POST' action="/delete-item">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="product_id" value='{{$itemdata->id}}'/>
                    <button type="submit"
                    class="h-9  w-[120px] text-red-500 font-medium">
                    Delete
                    </button>
                </form>
                <div class="flex justify-end ">
                    <a href="/items" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                        ← Back
                    </a>
                </div>
            </div>

            <form method="POST" action="/update-item" class="grid gap-5 p-3">
                @csrf
                @method('PUT')
 
                <input type="hidden" name="product_id"  value="{{$itemdata->id}}" />

                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="bar_code" class="text-sm font-medium text-gray-500">Bar Code</label>
                    <input type="text" name="bar_code" id="bar_code" placeholder="Enter bar code"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->barcode }}" required>
                </div>

                {{-- Item Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="product_name" class="text-sm font-medium text-gray-500">Item Name*</label>
                    <input type="text" name="product_name" id="product_name" placeholder="Enter item name"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->product_name}}">
                </div>
                {{-- Item Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="hsn_code" class="text-sm font-medium text-gray-500">HSN*</label>
                    <input type="text" name="hsn_code" id="hsn_code" placeholder="Enter item name"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->hsn_code}}">
                </div>
                
                {{-- Item Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="price_per_unit" class="text-sm font-medium text-gray-500">Price Per Unit*</label>
                    <input type="text" name="price_per_unit" id="price_per_unit" placeholder="Enter unit price"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->price_per_unit}}">
                </div>

                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="selling_price_per_unit" class="text-sm font-medium text-gray-500">Selling Price Per Unit*</label>
                    <input type="text" name="selling_price_per_unit" id="selling_price_per_unit" placeholder="Enter Selling unit price"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{ $itemdata->selling_price_per_unit }}" required>
                </div>

                    {{-- Unit Dropdown --}}
                    <div class="grid md:grid-cols-6 md:gap-2 items-center">
                        <label for="unit_id" class="text-sm font-medium text-gray-500">Units*</label>
                        <div class="md:col-span-4 lg:col-span-2">
                            <select name="unit_id" id="unit_id"
                                class="w-full p-2 border border-gray-300 bg-white rounded-md">
                                <option value="">Select a unit...</option>
                                <option value="Piece" {{ old('unit_id', $itemdata->unit_id) == "Piece" ? 'selected' : '' }}>Piece</option>
                                <option value="Dozen" {{ old('unit_id', $itemdata->unit_id) == "Dozen" ? 'selected' : '' }}>Dozen</option>
                                <option value="Set" {{ old('unit_id', $itemdata->unit_id) == "Set" ? 'selected' : '' }}>Set</option>
                                <option value="Bundle" {{ old('unit_id', $itemdata->unit_id) == "Bundle" ? 'selected' : '' }}>Bundle</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tax Type Dropdown --}}
                    <div class="grid md:grid-cols-6 md:gap-2 items-center">
                        <label for="tax_type_id" class="text-sm font-medium text-gray-500">Tax Type*</label>
                        <div class="md:col-span-4 lg:col-span-2">
                            <select name="tax_type_id" id="tax_type_id"
                                class="w-full p-2 border border-gray-300 bg-white rounded-md">
                                <option value="">Select tax type...</option>
                                <option value="GST" {{ old('tax_type_id', $itemdata->tax_type_id) == "GST" ? 'selected' : '' }}>GST</option>
                                <option value="IGST" {{ old('tax_type_id', $itemdata->tax_type_id) == "IGST" ? 'selected' : '' }}>IGST</option>
                                <option value="Exempt" {{ old('tax_type_id', $itemdata->tax_type_id) == "Exempt" ? 'selected' : '' }}>Exempt</option>
                            </select>
                        </div>
                    </div>

                {{-- Tax Percentage --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="tax_percentage" class="text-sm font-medium text-gray-500">Tax %*</label>
                    <input type="number" name="tax_percentage" id="tax_percentage" placeholder="Enter tax percentage"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->tax_percentage}}">
                </div>


                {{-- Description --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="description" class="text-sm font-medium text-gray-500">Description</label>
                    <input type="text" name="description" id="description" placeholder="Enter product description"
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md"
                        value="{{$itemdata->description}}">
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 mt-4">
                    <button type="submit" class="w-[120px] bg-blue-500 text-white hover:bg-blue-600 rounded-md h-9 px-4 py-1">
                        Update Item
                    </button>
                    
                </div>
            </form>

        </div>
    </x-pagestructure>
</x-layout>
