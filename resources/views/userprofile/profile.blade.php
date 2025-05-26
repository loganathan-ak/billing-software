<x-layout>
    <x-pagestructure>
        <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl mt-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">User Profile</h2>

            @if(Session::has('access'))
            <p class="bg-green-100 text-green-800 text-sm font-medium px-4 py-4 rounded-lg shadow-md mb-5">
                {{ session('access') }}
            </p>
            @endif

            @if($errors->any())
            <ul class="bg-red-100 text-red-800 text-sm font-medium px-4 py-4 rounded-lg shadow-md mt-4 list-disc pl-5 ">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Full Name</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                </div>
        
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email Address</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Contact Number</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->contact_number }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">GST Number</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->gst_number }}</p>
                </div>
        
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Company Name</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->company_name }}</p>
                </div>
        
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                    <p class="font-medium text-gray-900 dark:text-white">{{ $user->address }}</p>
                </div>
        
                
        
                
            </div>
        
            <div class="mt-8 text-right">
                <a href="{{route('editprofile')}}" class="inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow">
                    Edit Profile
                </a>
            </div>
        </div>
        
        
    </x-pagestructure>
    
</x-layout>