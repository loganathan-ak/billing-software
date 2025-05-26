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
            <a href="/reports" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
        <div class="bg-white p-8 rounded-2xl shadow-xl">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 border-b pb-2">Customer Sales Report</h2>
        
            <!-- Filters -->
            <form method="GET" action="/customer-salesreport" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="customer_start_date"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="customer_end_date"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                    <select name="customer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">All Customers</option>
                        @foreach($customersWithoutGst as $customer)
                            <option value="{{ $customer->id }}" >
                                {{ $customer->customer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Filter
                    </button>
                </div>
            </form>
            <div class="flex justify-end mb-5">
            <button onclick="exportToExcel()" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-md shadow transition">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 10V4a1 1 0 0 0-1-1H9.914a1 1 0 0 0-.707.293L5.293 7.207A1 1 0 0 0 5 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2M10 3v4a1 1 0 0 1-1 1H5m5 6h9m0 0-2-2m2 2-2 2"/>
                </svg>
                Export
              </button>
            </div>
              
            
        
            <!-- Customer Sales Table -->
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full text-sm text-left table-auto" id="table-product-list">
                    <thead class="bg-blue-50 text-gray-700 font-semibold">
                        <tr>
                            <th class="p-4 border-b">Invoice #</th>
                            <th class="p-4 border-b">Invoice Date</th>
                            <th class="p-4 border-b">Customer</th>
                            <th class="p-4 border-b text-right">CGST (₹)</th>
                            <th class="p-4 border-b text-right">SGCT (₹)</th>
                            <th class="p-4 border-b text-right">Total (₹)</th>
                            <th class="p-4 border-b text-right">Paid (₹)</th>
                            <th class="p-4 border-b text-right">Balance (₹)</th>
                            <th class="p-4 border-b">Payment Method</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                         
                 
                        @php
                            $totalCgst = 0;
                            $totalSgst = 0;
                            $totalAmount = 0;
                            $totalPaid = 0;
                            $totalBalance = 0;
                           
                        @endphp

                        @forelse($customerSales as $sale)
                            @php
                                $cgst = $sale->total_tax / 2 ?? 0;
                                $sgst = $sale->total_tax / 2 ?? 0;
                                $totalCgst += $cgst;
                                $totalSgst += $sgst;
                                $totalAmount += $sale->grand_total;
                                $totalPaid += $sale->paid_amount;
                                $totalBalance += $sale->balance;
                            @endphp
                            <tr class="hover:bg-gray-100 transition">
                                <td class="p-4 border-b">{{ $sale->invoice_number }}</td>
                                <td class="p-4 border-b">{{ $sale->invoice_date }}</td>
                                <td class="p-4 border-b">{{ $customers->where('id', $sale->customer_id)->first()->customer_name }}</td>
                                <td class="p-4 border-b text-right">{{ number_format($cgst, 2) }}</td>
                                <td class="p-4 border-b text-right">{{ number_format($sgst, 2) }}</td>
                                <td class="p-4 border-b text-right">{{ number_format($sale->grand_total, 2) }}</td>
                                <td class="p-4 border-b text-right">{{ number_format($sale->paid_amount, 2) }}</td>
                                <td class="p-4 border-b text-right">{{ number_format($sale->balance, 2) }}</td>
                                <td class="p-4 border-b">{{ $sale->payment_method }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-4 text-center text-gray-500">No customer sales found.</td>
                            </tr>
                        @endforelse

                        <!-- Totals Row -->
                        <tr class="font-semibold bg-blue-50 text-gray-800">
                            <td class="p-4 border-t" colspan="3">Total</td>
                            <td class="p-4 border-t text-right">{{ number_format($totalCgst, 2) }}</td>
                            <td class="p-4 border-t text-right">{{ number_format($totalSgst, 2) }}</td>
                            <td class="p-4 border-t text-right">{{ number_format($totalAmount, 2) }}</td>
                            <td class="p-4 border-t text-right">{{ number_format($totalPaid, 2) }}</td>
                            <td class="p-4 border-t text-right">{{ number_format($totalBalance, 2) }}</td>
                            <td class="p-4 border-t"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
              
        </div>
    </x-pagestructure>
</x-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>

function exportToExcel() {
    var table = document.getElementById('table-product-list');
    var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(wb, 'download.xlsx');
}


</script>

