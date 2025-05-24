<section class="container px-4 mx-auto mt-5">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Business Sales Invoice</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400">{{$counts}} Invoice</span>
            </div>

        </div>

        <div class="flex items-center mt-4 gap-x-3">

            <a href="/add-business-invoice" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <span>Add Invoice</span>
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

            <input type="text" placeholder="Invoice number" id="search_query"  class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
        </div>
    </div>

    <div class="flex flex-col mt-6">
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
                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Invoice Date
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Invoice#
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Customer Name</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">GST Number</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Invoice Amount</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Payment Status</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Action</th>


                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900" id="business-to-bussiness-tbody">
                            @foreach( $invoices as $invoice)
                            <tr>
                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400"> {{$invoice->invoice_date}}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">{{$invoice->invoice_number}}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">{{$customers->where('id', $invoice->customer_id)->first()->customer_name}}</p>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">{{$customers->where('id', $invoice->customer_id)->first()->gst_number}}</p>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">{{$invoice->grand_total}}</p>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div >
                                        <p class="text-gray-500 dark:text-gray-400">{{$invoice->payment_status}}</p>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <a href="/view-business-invoice/{{$invoice->id}}" class="px-1 py-1 text-blue-500 font-medium transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                        View
                                    </a>
                                    <a href="/edit-business-invoice/{{$invoice->id}}" class="px-3 font-medium py-1 text-blue-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                       Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            


                        </tbody>
                    </table>

                    <div class="mt-5">
                        {{-- {{ $invoices->links() }} --}}
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
        url: '/b2b-search',
        type: 'GET',
        data: { query: query },
        success: function (data) {
            console.log(data);

            $('#business-to-bussiness-tbody').empty();

            let invoices = data.invoice;
            let customers = data.customers;

            if (invoices.length > 0) {
                invoices.forEach(function(invoice) {
                    let customer = customers.find(c => c.id == invoice.customer_id);
                    let customerName = customer ? customer.customer_name : 'Unknown';
                    let customerGst = customer ? customer.gst_number : 'N/A';

                    let row = `<tr>
                        <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${invoice.invoice_date}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${invoice.invoice_number}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${customerName}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${customerGst}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${invoice.grand_total}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400">${invoice.payment_status}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                            <a href="/view-business-invoice/${invoice.id}" class="px-1 py-1 text-blue-500 font-medium transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                View
                            </a>
                            <a href="/edit-business-invoice/${invoice.id}" class="px-3 font-medium py-1 text-blue-500 transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                Edit
                            </a>
                        </td>
                    </tr>`;

                    $('#business-to-bussiness-tbody').append(row);
                });
            } else {
                $('#business-to-bussiness-tbody').append(`
                    <tr>
                        <td colspan="7" class="text-center px-4 py-4 text-sm text-gray-500">
                            No invoices found.
                        </td>
                    </tr>
                `);
            }
        }
    });
});



</script>