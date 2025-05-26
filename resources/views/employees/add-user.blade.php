<x-layout> 
    <x-pagestructure>
        @if($errors->any())
            <ul class="bg-red-100 text-red-800 text-sm font-medium px-4 py-3 rounded-lg shadow-md mt-4 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

       

        <form action="/add-user" method="POST" class="p-4">
            @csrf
    
            <!-- Name Field -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center">
                <label for="name" class="text-sm font-medium text-gray-500">
                    Name*
                </label>
                <input type="text" id="name" name="name" placeholder="Enter user name"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2"
                    value="{{ old('name') }}" required>
            </div>
    
            <!-- Password Field -->
            <div class="grid md:grid-cols-6 md:gap-2 items-center mt-4">
                <label for="password" class="text-sm font-medium text-gray-500">
                   Password (leave blank to keep the same)
                </label>
                <input type="password" id="password" name="password" placeholder="Enter new password"
                    class="p-2 border border-gray-300 bg-white rounded-md md:col-span-4 lg:col-span-2">
            </div>
    
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
        </form>
    </x-pagestructure>
</x-layout>
