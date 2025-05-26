<section class="container px-4 mx-auto mt-5">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Expenses</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{$counts}} expenses</span>
            </div>

        </div>

        <div class="flex items-center mt-4 gap-x-3">
            {{-- <button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_3098_154395)">
                    <path d="M13.3333 13.3332L9.99997 9.9999M9.99997 9.9999L6.66663 13.3332M9.99997 9.9999V17.4999M16.9916 15.3249C17.8044 14.8818 18.4465 14.1806 18.8165 13.3321C19.1866 12.4835 19.2635 11.5359 19.0351 10.6388C18.8068 9.7417 18.2862 8.94616 17.5555 8.37778C16.8248 7.80939 15.9257 7.50052 15 7.4999H13.95C13.6977 6.52427 13.2276 5.61852 12.5749 4.85073C11.9222 4.08295 11.104 3.47311 10.1817 3.06708C9.25943 2.66104 8.25709 2.46937 7.25006 2.50647C6.24304 2.54358 5.25752 2.80849 4.36761 3.28129C3.47771 3.7541 2.70656 4.42249 2.11215 5.23622C1.51774 6.04996 1.11554 6.98785 0.935783 7.9794C0.756025 8.97095 0.803388 9.99035 1.07431 10.961C1.34523 11.9316 1.83267 12.8281 2.49997 13.5832" stroke="currentColor" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_3098_154395">
                    <rect width="20" height="20" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>

                <span>Import</span>
            </button> --}}

            <a href="/add-expenses" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span>Add Expenses</span>
            </a>
        </div>
    </div>

    <div class="mt-6 md:flex md:items-center md:justify-between">
        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>

            <input type="text" placeholder="Search" id="search_query" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>
    </div>

    <div class="mt-5">
        @if(Session::has('updated'))
        <div class="mb-4 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-800 shadow">
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
    </div>


    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-3 focus:outline-none">
                                        <span>Expense</span>
                                    </button>
                                </th>

                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Type Of Expense
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Amount
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Beneficiary For</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Description</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Created On</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Action</th>

                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900" id="expenses-table-body">

                         @foreach($expenses as $expense)
                         <tr>
                            <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                <div>
                                    <h2 class="font-medium text-gray-800 dark:text-white ">{{$expense->expense_name}}</h2>
                                </div>
                            </td>
                            <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400">
                                    {{$expense->expense_type}}
                                </div>
                            </td>
                            <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                <div class="text-gray-500 dark:text-gray-400">
                                    {{$expense->amount}}
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">{{$expense->beneficiary_name}}</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <p class="text-gray-500 dark:text-gray-400">{{$expense->description}}</p>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center">
                                    <p class="text-gray-500 dark:text-gray-400">{{$expense->created_at}}</p>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <a href="/edit-expense/{{$expense->id}}" class="px-3 py-1 text-blue-500 font-medium transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                    Edit
                                </a>
                            </td>
                        </tr>
                         @endforeach

                            

                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{ $expenses->links() }}
                        </div>
                </div>
            </div>
        </div>
    </div>


</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $('#search_query').on('input', function () {
        let query = $(this).val();
    
        $.ajax({
            url: '/expenses-search',
            type: 'GET',
            data: { query: query },
            success: function (data) {
    $('#expenses-table-body').empty(); // Replace with your actual tbody ID

    let expenses = data.expenses;

    if (expenses.length > 0) {
        expenses.forEach(function (expense) {
            let row = `<tr>
                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                    <div>
                        <h2 class="font-medium text-gray-800 dark:text-white">${expense.expense_name}</h2>
                    </div>
                </td>
                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                    <div class="text-gray-500 dark:text-gray-400">
                        ${expense.expense_type}
                    </div>
                </td>
                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                    <div class="text-gray-500 dark:text-gray-400">
                        ${expense.amount}
                    </div>
                </td>
                <td class="px-4 py-4 text-sm whitespace-nowrap">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">${expense.beneficiary_name}</p>
                    </div>
                </td>
                <td class="px-4 py-4 text-sm whitespace-nowrap">
                    <div class="flex items-center">
                        <p class="text-gray-500 dark:text-gray-400">${expense.description || ''}</p>
                    </div>
                </td>
                <td class="px-4 py-4 text-sm whitespace-nowrap">
                    <div class="flex items-center">
                        <p class="text-gray-500 dark:text-gray-400">${expense.created_at}</p>
                    </div>
                </td>
                <td class="px-4 py-4 text-sm whitespace-nowrap">
                    <a href="/edit-expense/${expense.id}" class="px-3 py-1 text-blue-500 font-medium transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                        Edit
                    </a>
                </td>
            </tr>`;

            $('#expenses-table-body').append(row);
        });
    } else {
        $('#expenses-table-body').append(`
            <tr>
                <td colspan="7" class="text-center px-4 py-4 text-sm text-gray-500">
                    No expenses recorded.
                </td>
            </tr>
        `);
    }
},

        error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

</script>