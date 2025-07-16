<section class="container px-4 mx-auto mt-5">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 ">Customer Chit Records</h2>
                {{-- <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full ">{{ $chits->count() }} Chits</span> --}}
            </div>
        </div>

        <div class="flex items-center mt-4 gap-x-3">
            <a href="{{route('chits.addchits')}}" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Add Chit</span>
            </a>
        </div>
    </div>

    <div class="mt-6 md:flex md:items-center md:justify-between">
        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>
            <input type="text" placeholder="Search" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>
    </div>

    <div class="flex flex-col mt-6">
        @if(Session::has('updated'))
            <div class="mb-4 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-800 shadow">{{ Session::get('updated') }}</div>
        @elseif(Session::has('added'))
            <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800 shadow">{{ Session::get('added') }}</div>
        @elseif(Session::has('deleted'))
            <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800 shadow">{{ Session::get('deleted') }}</div>
        @endif
    </div>

    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200  md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-50 ">
                            <tr>
                                <th class="px-6 py-3 text-sm font-normal text-left text-gray-500">Chit Date</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Customer Name</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Contact Number</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Amount</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Chit Status</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Months</th>
                                <th class="px-4 py-3 text-sm font-normal text-left text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 ">
                            @foreach($chits as $chit)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-600 ">{{ $chit->start_date }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600 ">
                                    {{ $customers->where('id', $chit->customer_id)->first()->customer_name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 ">
                                    {{ $customers->where('id', $chit->customer_id)->first()->contact_number ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600 ">{{ number_format($chit->monthly_amount, 2) }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600 ">{{ ucfirst($chit->chit_status) }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600 ">{{ $chit->month_number }} / {{ $chit->total_months }}</td>
                                <td class="px-4 py-4 text-sm text-blue-600  whitespace-nowrap">
                                    <a href="{{route('view.chit', $chit->id)}}" class="mr-2 hover:underline">View</a>
                                    <a href="{{ route('chit.update', $chit->id) }}" class="hover:underline">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-5 px-4">
                        {{-- {{ $chits->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
