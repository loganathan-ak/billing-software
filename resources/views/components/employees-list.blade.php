<section class="container px-4 mx-auto mt-5">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Employees</h2>
            </div>
        </div>
        <a href="/add-user" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <span>Add User</span>
        </a>
    </div>

     
    <div class="flex flex-col mt-6">
        @if(Session::has('updated'))
        <div class="mb-4 rounded-lg bg-blue-100 px-4 py-3 text-sm text-green-800 shadow">
            {{ Session::get('updated') }}
        </div>
    @elseif(Session::has('added'))
        <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800 shadow">
            {{ Session::get('added') }}
        </div>
    @elseif(Session::has('deleted'))
        <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800 shadow">
            {{ Session::get('deleted') }}
        </div>
    @endif
    
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Username</th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Password</th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Actions</th>

                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900" >
                            @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                    <div>
                                        <h2 class="font-medium text-gray-800 dark:text-white">{{$user->name}}</h2>
                                    </div>
                                </td>
                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                    <p class="font-normal text-gray-800">**********</p> <!-- Masked password -->
                                </td>
                                
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <a href="/edit-user/{{$user->id}}" class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">Edit</a>  
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>