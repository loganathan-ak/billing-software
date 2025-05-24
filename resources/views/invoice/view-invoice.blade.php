<x-layout> 
    <x-pagestructure>
        <div class="flex justify-end m-5">
            <a href="/sales-invoice" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
        
        

        <div id="invoice" class="max-w-5xl mx-auto border border-gray-300 rounded-2xl p-10 shadow-2xl bg-white font-sans text-gray-800">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <div class="max-w-[200px]">
                    @php
                            $admin = \App\Models\User::where('user_role', 'admin')->first();
                        @endphp

                        @if($admin)
                            <h2 class="text-3xl font-extrabold text-[#062242]">{{ $admin->company_name }}</h2>
                            <p class="mt-1 text-sm text-gray-600 leading-5">
                                {{ $admin->address }}<br>
                                Phone: {{ $admin->contact_number }}<br>
                                Email: {{ $admin->email }}
                            </p>
                        @endif
                </div>
                <div class="text-right">
                    <img src="{{ asset('CaravaLogo-1.png') }}" alt="Logo" class="w-28 mb-2">
                    <h1 class="text-4xl font-bold text-[#062242] tracking-wider">INVOICE</h1>
                </div>
            </div>
        
            <!-- Bill To & Invoice Info -->
            <div class="grid grid-cols-2 gap-8 mb-8 text-sm">
                <div>
                    <h3 class="font-bold text-[#062242] mb-1">Bill To:</h3>
                    <p class="text-gray-700">
                        {{ $customers->where('id', $invoice->customer_id)->first()->customer_name ?? 'Unknown' }}<br>
                        {{ $customers->where('id', $invoice->customer_id)->first()->contact_number ?? 'Unknown' }}
                    </p>
                </div>
                <div class="text-right">
                    <p><strong>Invoice No:</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
                </div>
            </div>
        
            <!-- Items Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden mb-10 main_table">
                    <thead class="bg-[#062242] text-white">
                        <tr>
                            <th class="p-3 border">#</th>
                            <th class="p-3 border">Description</th>
                            <th class="p-3 border">HSN</th>
                            <th class="p-3 border">Qty</th>
                            <th class="p-3 border">Price</th>
                            <th class="p-3 border">CGST</th>
                            <th class="p-3 border">SGST</th>
                            <th class="p-3 border">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (json_decode($invoice->item_details, true) as $index => $item)
                        <tr class="even:bg-gray-50">
                            <td class="p-3 border text-center">{{ $index + 1 }}</td>
                            <td class="p-3 border">
                                <strong>{{ $getitems->where('id', $item['product_id'])->first()->product_name ?? 'Unknown' }}</strong><br>
                                <span class="text-xs text-gray-500">Barcode: {{ $item['barcode'] }}</span>
                            </td>
                            <td class="p-3 border text-center">{{ $getitems->where('id', $item['product_id'])->first()->hsn_code ?? 'Unknown' }}</td>
                            <td class="p-3 border text-center">{{ $item['quantity'] }}</td>
                            <td class="p-3 border text-right">₹{{ number_format($item['price'], 2) }}</td>
                            <td class="p-3 border text-right">
                                ₹{{ number_format($item['cgst'], 2) }}
                                <span class="block text-xs text-gray-500">({{ number_format($item['tax'] / 2, 2) }}%)</span>
                            </td>
                            <td class="p-3 border text-right">
                                ₹{{ number_format($item['sgst'], 2) }}
                                <span class="block text-xs text-gray-500">({{ number_format($item['tax'] / 2, 2) }}%)</span>
                            </td>
                            <td class="p-3 border text-right">₹{{ number_format($item['total'], 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="font-semibold bg-gray-100">
                            <td colspan="5" class="p-3 border text-right">Total</td>
                            <td class="p-3 border text-right">₹<span class="total_cgst">0</span></td>
                            <td class="p-3 border text-right">₹<span class="total_sgst">0</span></td>
                            <td class="p-3 border text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        
            <!-- Summary -->
            <div class="grid grid-cols-2 gap-8 mt-10 text-sm">
                <!-- Tax Breakdown (Left Side) -->
                <div class="border rounded-lg p-4 shadow bg-gray-50">
                    <h3 class="text-lg font-bold text-[#062242] mb-4 border-b pb-2">Tax Breakdown</h3>
                    <div class="flex justify-between py-1">
                        <span>CGST</span>
                        <span>₹<span class="total_cgst">0</span></span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>SGST</span>
                        <span>₹<span class="total_sgst">0</span></span>
                    </div>
                    <div class="flex justify-between py-1 border-t mt-2 pt-2 font-semibold">
                        <span>Total Tax</span>
                        <span>₹{{ number_format($invoice->total_tax, 2) }}</span>
                    </div>
                </div>
        
                <!-- Payment Summary (Right Side) -->
                <div class="border rounded-lg p-4 shadow bg-gray-50">
                    <h3 class="text-lg font-bold text-[#062242] mb-4 border-b pb-2">Payment Summary</h3>
                
                    <div class="flex justify-between py-1">
                        <span>Taxable Value</span>
                        <span>₹{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                
                    @if($invoice->discount_percent > 0)
                        <div class="flex justify-between py-1">
                            <span>Discount ({{ $invoice->discount_percent }}%)</span>
                            <span>-₹{{ number_format($invoice->discount_amount) }}</span>
                        </div>
                    @endif
                
                    <div class="flex justify-between py-1">
                        <span>Tax Amount</span>
                        <span>₹{{ number_format($invoice->total_tax, 2) }}</span>
                    </div>
                
                    <div class="flex justify-between text-base font-bold border-t mt-2 pt-2">
                        <span>Total Invoice Value</span>
                        <span>₹{{ number_format($invoice->grand_total, 2) }}</span>
                    </div>
                
                    <div class="flex justify-between py-1">
                        <span>Paid Amount</span>
                        <span>₹{{ number_format($invoice->paid_amount, 2) }}</span>
                    </div>
                
                    <div class="flex justify-between py-1 text-red-600 font-semibold">
                        <span>Balance Due</span>
                        <span>₹{{ number_format($invoice->balance, 2) }}</span>
                    </div>
                </div>
                
            </div>
        
            <!-- Signature -->
            <div class="flex justify-between items-center mt-16">
                <div class="text-center text-sm">
                    <h4 class="font-medium">Created by</h4>
                    <p class="border-t-2 border-gray-400 w-48 mx-auto pt-1">{{\App\Models\User::where('id', $invoice->created_by)->first()->name ?? 'Unknown'}}</p>
                </div>
                <div class="text-center text-sm">
                    <h4 class="font-medium">Loganathan.s</h4>
                    <p class="border-t-2 border-gray-400 w-48 mx-auto pt-1">Authorized Signatory</p>
                </div>
            </div>
        
            <!-- Print Button -->
            <div class="text-center mt-12 ">
                <button onclick="printInvoice()" class="bg-[#062242] hover:bg-[#03182d] text-white px-8 py-3 rounded-lg shadow-md font-semibold">
                    Print Invoice
                </button>
            </div>
        </div>
        
    

        

            
        </x-pagestructure>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function printInvoice() {
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    $(document).ready(function () {
    var cgstTotal = 0;
    var sgstTotal = 0;

    $('.main_table tbody tr').each(function () {
        var cgstText = $(this).find('td:nth-child(6)').text().trim();
        var sgstText = $(this).find('td:nth-child(7)').text().trim();

        var cgstValue = parseFloat(cgstText.replace('%', '').replace('₹', '').replace(/,/g, '')) || 0;
        var sgstValue = parseFloat(sgstText.replace('%', '').replace('₹', '').replace(/,/g, '')) || 0;

        cgstTotal += cgstValue;
        sgstTotal += sgstValue;
    });
    
    $('.total_cgst').text(cgstTotal);
    $('.total_sgst').text(sgstTotal);

});






</script>

</x-layout>