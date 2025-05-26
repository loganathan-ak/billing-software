<x-layout> 
    <x-pagestructure>
        <div class="flex justify-end m-5">
            <a href="/items" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
        <div class="max-w-7xl mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Item Details</h1>
        
            <!-- Item Info Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-700">
                    <div>
                        <strong>Product Name:</strong>
                        <p>{{ $item->product_name }}</p>
                    </div>
                    <div>
                        <strong>Barcode:</strong>
                        <p>{{ $item->barcode ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong>HSN Code:</strong>
                        <p>{{ $item->hsn_code ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong>Price Per Unit:</strong>
                        <p>₹{{ number_format($item->price_per_unit, 2) }}</p>
                    </div>
                    <div>
                        <strong>Selling Price Per Unit:</strong>
                        <p>₹{{ number_format($item->selling_price_per_unit, 2) }}</p>
                    </div>
                    <div>
                        <strong>Unit:</strong>
                        <p>{{ $item->unit_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong>Tax Type:</strong>
                        <p>{{ $item->tax_type_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <strong>Tax %:</strong>
                        <p>{{ $item->tax_percentage ?? 0 }}%</p>
                    </div>
                    <div class="md:col-span-2">
                        <strong>Description:</strong>
                        <p>{{ $item->description ?? 'No description' }}</p>
                    </div>
                </div>
            </div>
        
            <!-- Stock Summary -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Stock Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center text-sm font-medium">

                    @php
                    $purchasetotal = 0;
                    
                    foreach ($purchases as $purchase) {
                        $products = json_decode($purchase->item_details, true);
                        if (!$products) continue;
                    
                        foreach ($products as $product) {
                            if ($product['product_id'] == $item->id) {
                                $purchasetotal += (float) $product['quantity'];
                            }
                        }
                    }
                    
                    $salestotal = 0;
                    
                    // Normal Sales
                    foreach ($salesorders as $solditem) {
                        $sales = json_decode($solditem->item_details, true);
                        if (!$sales) continue;
                    
                        foreach ($sales as $sale) {
                            if ($sale['product_id'] == $item->id) {
                                $salestotal += (float) $sale['quantity'];
                            }
                        }
                    }
                    
                    // B2B Sales
                    foreach ($b2borders as $b2bsale) {
                        $b2bsales = json_decode($b2bsale->item_details, true);
                        if (!$b2bsales) continue;
                    
                        foreach ($b2bsales as $sale) {
                            if ($sale['product_id'] == $item->id) {
                                $salestotal += (float) $sale['quantity'];
                            }
                        }
                    }
                    
                    $currenttotal = $purchasetotal - $salestotal;
                    @endphp
                    

                    <div class="p-4 bg-blue-50 rounded">
                        <p class="text-gray-600">Total Purchased</p>
                        <p class="text-xl font-bold text-blue-700">{{$purchasetotal}}</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded">
                        <p class="text-gray-600">Total Sold</p>
                        <p class="text-xl font-bold text-green-700">{{$salestotal}}</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded">
                        <p class="text-gray-600">Current Stock</p>
                        <p class="text-xl font-bold text-yellow-700">{{$currenttotal}}</p>
                    </div>
                </div>
            </div>
        
            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Purchases </h2>
        
                <div class="overflow-x-auto">
                    
                        <table class="w-full text-sm border rounded-md mt-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">Date</th>
                                    <th class="border p-2">Quantity</th>
                                    <th class="border p-2">Price per unit</th>
                                    <th class="border p-2">Tax (%)</th>
                                    <th class="border p-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchase)
                                @php
                                    $purchaselists = json_decode($purchase->item_details, true);
                                @endphp

                                @foreach($purchaselists as $purchaselist)
                                    @if($purchaselist['product_id'] == $item->id)
                                        <tr>
                                            <td class="border p-2">{{ $purchase->invoice_date }}</td>
                                            <td class="border p-2">{{ $purchaselist['quantity'] }}</td>
                                            <td class="border p-2">{{ $purchaselist['price'] }}</td>
                                            <td class="border p-2">{{ $purchaselist['tax'] }}%</td>
                                            <td class="border p-2">{{ $purchaselist['total'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach


                            </tbody>
                        </table>
               

                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow p-6 mt-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Sales</h2>
        
                <div class="overflow-x-auto">
                    
                        <table class="w-full text-sm border rounded-md mt-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">Date</th>
                                    <th class="border p-2">Quantity</th>
                                    <th class="border p-2">Price per unit</th>
                                    <th class="border p-2">Tax (%)</th>
                                    <th class="border p-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesorders as $salesorder)
                                @php
                                    $saleslists = json_decode($salesorder->item_details, true);
                                @endphp

                                @foreach($saleslists as $saleslist)
                                    @if($saleslist['product_id'] == $item->id)
                                        <tr>
                                            <td class="border p-2">{{ $salesorder->invoice_date }}</td>
                                            <td class="border p-2">{{ $saleslist['quantity'] }}</td>
                                            <td class="border p-2">{{ $saleslist['price'] }}</td>
                                            <td class="border p-2">{{ $saleslist['tax'] }}%</td>
                                            <td class="border p-2">{{ $saleslist['total'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach


                            </tbody>
                        </table>
               

                </div>
            </div>


            <!-- B2B Transactions -->
                <div class="bg-white rounded-lg shadow p-6 mt-5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent B2B Sales</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border rounded-md mt-4">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2">Date</th>
                                    <th class="border p-2">Quantity</th>
                                    <th class="border p-2">Price per unit</th>
                                    <th class="border p-2">Tax (%)</th>
                                    <th class="border p-2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($b2borders as $b2border)
                                    @php
                                        $b2blists = json_decode($b2border->item_details, true);
                                    @endphp

                                    @foreach($b2blists as $b2blist)
                                        @if($b2blist['product_id'] == $item->id)
                                            <tr>
                                                <td class="border p-2">{{ $b2border->invoice_date }}</td>
                                                <td class="border p-2">{{ $b2blist['quantity'] }}</td>
                                                <td class="border p-2">{{ $b2blist['price'] }}</td>
                                                <td class="border p-2">{{ $b2blist['tax'] }}%</td>
                                                <td class="border p-2">{{ $b2blist['total'] }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

        </div>
    </x-pagestructure>
</x-layout>
