<section class="container px-4 mx-auto mt-5">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-medium text-gray-800 dark:text-white">Inventory</h2>

                <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400"> Items</span>
            </div>

        </div>
    </div>

    <div class="mt-6 md:flex md:items-center md:justify-between">
        <div class="relative flex items-center mt-4 md:mt-0">
            <span class="absolute">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 dark:text-gray-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>

            <input type="text" placeholder="Search" class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
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
                                        <span>Item Name</span>
                                    </button>
                                </th>

                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Unit
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Current Stock
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Average Price</th>


                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Action</th>

                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">

                         @foreach($items as $item)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                    <div>
                                        <h2 class="font-medium text-gray-800 dark:text-white ">{{$item->product_name}}</h2>
                                    </div>
                                </td>
                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class=" text-sm font-normal rounded-full text-emerald-500 gap-x-2 ">
                                        {{$item->unit_id}}
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $totalStock = 0;
                                            $totalSold = 0;
                                            $unit_type = 'Piece'; // default fallback
                                            $currentStock = null;
                                    
                                            $getcurrectItem = $purchases->where('item_id', $item->id);
                                            $rowcount = $getcurrectItem->count();
                                        @endphp
                                    
                                        @if($rowcount == 0)
                                            <p class="text-gray-600">Not Purchased Yet</p>
                                        @else
                                            @php
                                                // Purchases
                                                foreach($getcurrectItem as $purchase) {
                                                    $quantity = $purchase->quantity;
                                    
                                                    if ($item->unit_id === 'Dozen') {
                                                        $quantity *= 12;
                                                        $unit_type = 'Piece';
                                                    } else {
                                                        $unit_type = $item->unit_id;
                                                    }
                                    
                                                    $totalStock += $quantity;
                                                }
                                    
                                                // Sales
                                                foreach($salesorder as $sales) {
                                                    $products = json_decode($sales->item_details, true);
                                    
                                                    if (is_array($products)) {
                                                        foreach ($products as $saleItem) {
                                                            if (isset($saleItem['product_id']) && $saleItem['product_id'] == $item->id) {
                                                                $quantity = $saleItem['quantity'];
                                    
                                                                if ($item->unit_id === 'Dozen') {
                                                                    $quantity *= 12;
                                                                }
                                    
                                                                $totalSold += $quantity;
                                                            }
                                                        }
                                                    }
                                                }
                                    
                                                $currentStock = $totalStock - $totalSold;
                                            @endphp
                                    
                                            <p class="text-gray-600">{{ $currentStock }} {{ $unit_type }}</p>
                                        @endif
                                    </div>
                                    
                                    
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div class="flex items-center">
                                        @php
                                            $getcurrectItem = $purchases->where('item_id', $item->id);
                                            $rowcount = $getcurrectItem->count();
                                        @endphp
                                    
                                        @if($rowcount == 0)
                                            <p class="text-gray-600">Not Purchased Yet</p>
                                        @else
                                            @php
                                                $latestPurchaseOrder = $getcurrectItem->sortByDesc('created_at')->first();
                                                $latestquantity = $latestPurchaseOrder->quantity;
                                                $latestprice = $latestPurchaseOrder->selling_price ;
                                                $averageSellingPrice = round($latestprice / max($latestquantity, 1));

                                                if ($item->unit_id === 'Dozen') {
                                                    $totalpieces = $latestquantity *= 12;
                                                    $averageSellingPrice = round($latestprice / $totalpieces); 
                                                    } else {
                                                        $averageSellingPrice = round($latestprice / $latestquantity); 
                                                    }
                                            @endphp
                                            <p class="text-gray-600">₹{{ $averageSellingPrice }}</p>
                                        @endif
                                    </div>
                                    
                                </td>

                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <a href="/view-item/{{$item->id}}" class="px-3 py-1 text-blue-500 font-medium transition-colors duration-200 rounded-lg dark:text-gray-300 hover:bg-gray-100">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-5">
                       {{ $items->links() }} 
                        </div>
                </div>
            </div>
        </div>
    </div>


</section>