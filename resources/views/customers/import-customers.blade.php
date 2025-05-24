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
           

            <form method="POST" action="/import-customers" class="grid gap-5 p-3" enctype="multipart/form-data">
                @csrf
 

                {{-- Item Name --}}
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="customer_import" class="text-sm font-medium text-gray-500">Items File*</label>
                    <input type="file" id="customer_import" name="customer_import" class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md">
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 mt-4">
                    <button type="submit" class="w-[180px] bg-blue-500 text-white hover:bg-blue-600 rounded-md h-9 px-4 py-1">
                        Import Customers
                    </button>
                    
                </div>
            </form>

        </div>
    </x-pagestructure>
</x-layout>
