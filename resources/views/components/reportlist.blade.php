<div class="bg-white h-screen rounded-lg shadow-lg p-6 mb-6 transition-all duration-300 ease-in-out hover:shadow-xl">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Reports Dashboard</h2>

    <p class="text-gray-600 mb-6">Explore the various reports to track your business performance.</p>

   <!-- Report Types Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Customer Sales Report -->
    <div class="bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-600 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">Customer Sales</h3>
        <p class="text-sm mb-5">Monitor customer-wise sales performance, trends, and growth metrics for strategic insights.</p>
        <a href="/sales-report" class="inline-block px-6 py-3 bg-white text-blue-800 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Report</a>
    </div>

    <!-- B2B Sales Report -->
    <div class="bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">B2B Sales Overview</h3>
        <p class="text-sm mb-5 leading-relaxed">Analyze business transactions, evaluate key buyers, and manage B2B revenue pipelines efficiently.</p>
        <a href="/b2b-salesreport" class="inline-block px-6 py-3 bg-white text-indigo-700 font-semibold rounded-full shadow-md hover:bg-gray-100 transition">View Full Report</a>
    </div>

    @if(Auth::user()->user_role === 'admin')

    <!-- Purchase Report -->
    <div class="bg-gradient-to-br from-emerald-500 via-green-600 to-lime-600 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">Purchase Summary</h3>
        <p class="text-sm mb-5">Review procurement activity, track vendor engagement, and monitor total spending over time.</p>
        <a href="/purchase-report" class="inline-block px-6 py-3 bg-white text-green-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Report</a>
    </div>


    <!-- Profit & Loss Report -->
    <div class="bg-gradient-to-br from-rose-500 via-red-600 to-pink-600 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">Profit & Loss</h3>
        <p class="text-sm mb-5">Gain visibility into income vs. expenses and measure business profitability with precision.</p>
        <a href="/profit-loss-report" class="inline-block px-6 py-3 bg-white text-red-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">Analyze Report</a>
    </div>

    <!-- Tax Report -->
    <div class="bg-gradient-to-br from-cyan-500 via-teal-600 to-green-500 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">Tax Overview</h3>
        <p class="text-sm mb-5">Get a clear breakdown of taxes collected and due to maintain regulatory compliance.</p>
        <p class="text-sm">Coming soon...</p>
        {{-- <a href="/tax-report" class="inline-block px-6 py-3 bg-white text-teal-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Tax Report</a> --}}
    </div>

        <!-- Inventory Report -->
        <div class="bg-gradient-to-br from-indigo-600 via-violet-700 to-purple-800 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
            <h3 class="text-2xl font-bold mb-3">Inventory Tracker</h3>
            <p class="text-sm mb-5">Stay on top of stock levels, product movement, reorder points, and inventory valuation.</p>
            <p class="text-sm">Coming soon...</p>
            {{-- <a href="/inventory-report" class="inline-block px-6 py-3 bg-white text-indigo-800 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Inventory</a> --}}
        </div>

    <!-- Vendor Report -->
    <div class="bg-gradient-to-br from-orange-500 via-red-500 to-yellow-500 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
        <h3 class="text-2xl font-bold mb-3">Vendor Summary</h3>
        <p class="text-sm mb-5">Manage supplier performance, pending payments, and vendor-specific purchase analysis.</p>
        <p class="text-sm">Coming soon...</p>
        {{-- <a href="/vendor-report" class="inline-block px-6 py-3 bg-white text-orange-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Vendor Report</a> --}}
    </div>


        <!-- Customer Report -->
        <div class="bg-gradient-to-br from-amber-500 via-yellow-600 to-orange-500 p-6 rounded-2xl text-white text-center shadow-xl hover:scale-105 transform transition-all duration-300">
            <h3 class="text-2xl font-bold mb-3">Customer Insights</h3>
            <p class="text-sm mb-5">Access customer activity, outstanding balances, loyalty stats, and buying behaviors.</p>
            <p class="text-sm">Coming soon...</p>
            {{-- <a href="/customer-report" class="inline-block px-6 py-3 bg-white text-yellow-700 font-semibold rounded-full shadow hover:bg-gray-100 transition">View Insights</a> --}}
        </div>


    @endif
</div>

</div>
