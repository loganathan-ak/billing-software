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
            <h2 class="text-3xl font-semibold text-gray-800 mb-6 border-b pb-2">Profit & Loss Report</h2>
        
            <!-- Filters -->
            <form method="GET" action="/profit-loss-filter" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" name="start_date"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" name="end_date"  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Filter</button>
                </div>
            </form>
        
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-green-100 p-4 rounded-lg text-green-800 font-semibold">
                    <div class="text-sm">Total Income</div>
                    <div class="text-2xl font-bold">₹{{ number_format($totalIncome, 2) }}</div>
                </div>
                <div class="bg-red-100 p-4 rounded-lg text-red-800 font-semibold">
                    <div class="text-sm">Total Expense</div>
                    <div class="text-2xl font-bold">₹{{ number_format($totalExpense, 2) }}</div>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg text-blue-800 font-semibold">
                    <div class="text-sm">Net Profit</div>
                    <div class="text-2xl font-bold">
                        ₹{{ number_format($netProfit, 2) }}
                    </div>
                </div>
            </div>
        
            <!-- Income Breakdown -->
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Income Breakup</h3>
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-blue-50 text-gray-700 font-semibold">
                        <tr>
                            <th class="p-4 border-b">Source</th>
                            <th class="p-4 border-b text-right">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="p-4 border-b">Customer Sales</td>
                            <td class="p-4 border-b text-right">{{ number_format($customerSales->sum('grand_total'), 2) }}</td>
                        </tr>
                        <tr>
                            <td class="p-4 border-b">B2B Sales</td>
                            <td class="p-4 border-b text-right">{{ number_format($b2bSales->sum('grand_total'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
            <!-- Expense Breakdown -->
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Expense Breakup</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-left">
                    <thead class="bg-red-50 text-gray-700 font-semibold">
                        <tr>
                            <th class="p-4 border-b">Type</th>
                            <th class="p-4 border-b text-right">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="p-4 border-b">Purchases</td>
                            <td class="p-4 border-b text-right">{{ number_format($purchases->sum('grand_total'), 2) }}</td>
                        </tr>
                        <tr>
                            <td class="p-4 border-b">Expenses</td>
                            <td class="p-4 border-b text-right">{{ number_format($expenses->sum('amount'), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        
        </div>
    </x-pagestructure>
</x-layout>
