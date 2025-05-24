

  <!-- Content -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="text-2xl font-semibold">{{$items}}</div>
                        </div>
                        <div class="text-sm font-medium text-gray-400">Items</div>
                    </div>
                </div>

                <a href="/items" class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
            </div>
            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="flex items-center mb-1">
                            <div class="text-2xl font-semibold">{{$vendors}}</div>
                        </div>
                        <div class="text-sm font-medium text-gray-400">Vendors</div>
                    </div>
                </div>

                <a href="/vendors" class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
            </div>

            <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-2xl font-semibold mb-1">{{$customers}}</div>
                        <div class="text-sm font-medium text-gray-400">Customers</div>
                    </div>
                </div>
                <a href="/customers" class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md lg:col-span-2">
                <div class="flex justify-between mb-4 items-start">
                    <div class="font-medium">Order Statistics</div>
                     <div class="dropdown">
                        <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i class="ri-more-fill"></i></button>
                        <ul class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                            <li>
                                <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                            </li>
                        </ul>
                    </div> 
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">{{$dailydata->pluck('sales')->sum()}}</div>
                            {{-- <span class="p-1 rounded text-[12px] font-semibold bg-blue-500/10 text-blue-500 leading-none ml-1">$80</span> --}}
                        </div>
                        <span class="text-gray-400 text-sm">Active</span>
                    </div>
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">{{$dailydata->pluck('b2b')->sum()}}</div>
                            {{-- <span class="p-1 rounded text-[12px] font-semibold bg-emerald-500/10 text-emerald-500 leading-none ml-1">+$469</span> --}}
                        </div>
                        <span class="text-gray-400 text-sm">Completed</span>
                    </div>
                    <div class="rounded-md border border-dashed border-gray-200 p-4">
                        <div class="flex items-center mb-0.5">
                            <div class="text-xl font-semibold">{{$dailydata->pluck('purchases')->sum()}}</div>
                            {{-- <span class="p-1 rounded text-[12px] font-semibold bg-rose-500/10 text-rose-500 leading-none ml-1">-$130</span> --}}
                        </div>
                        <span class="text-gray-400 text-sm">Canceled</span>
                    </div>
                </div>
                <div>
                    <canvas id="order-chart"></canvas>
                </div>
            </div>
            <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
                <div class="flex justify-between mb-4 items-start">
                    <div class="font-medium">Expenses</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[460px]">
                        <thead>
                            <tr>
                                <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md rounded-bl-md">Expense</th>
                                <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Type</th>
                                <th class="text-[12px] uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md rounded-br-md">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                            <tr>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <div class="flex items-center">
                                        <a  class="text-gray-600 text-sm font-medium hover:text-blue-500 ml-2 truncate">{{$expense->expense_name}}</a>
                                    </div>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="text-[13px] font-medium text-emerald-500">{{$expense->expense_type}}</span>
                                </td>
                                <td class="py-2 px-4 border-b border-b-gray-50">
                                    <span class="inline-block font-medium text-[12px] leading-none">{{$expense->amount}}</span>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  <!-- End Content -->

  

