<x-layout> 
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
        
            #invoice, #invoice * {
                visibility: visible;
            }
        
            #invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }
        
            /* Hide print button */
            button, .no-print {
                display: none !important;
            }
        
            /* Optional: Remove shadow and rounded corners for cleaner print */
            .shadow-md, .shadow, .rounded-2xl {
                box-shadow: none !important;
                border-radius: 0 !important;
            }
        
            /* Optional: Compact spacing for print */
            .p-8 {
                padding: 1rem !important;
            }
        
            .mb-6, .mt-6, .mb-10, .mt-12 {
                margin: 1rem 0 !important;
            }
        
            .border {
                border: 1px solid #000 !important;
            }
        
            .bg-white, .bg-gray-50 {
                background: #fff !important;
            }
        
            .text-white {
                color: #000 !important;
            }
        
            .bg-[#062242] {
                background: #ddd !important;
            }
        }
        </style>
        
    <x-pagestructure>
        <div class="flex justify-end m-5">
            
            <a href="/purchases" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>

        <div class="container mx-auto px-4 py-8" id="invoice">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Purchase Invoice</h1>
                        <p class="text-sm text-gray-500">Invoice #: {{ $purchase->invoice_number }}</p>
                        <p class="text-sm text-gray-500">Date: {{ $purchase->invoice_date }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-600">Vendor:</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $vendor->where('id', $purchase->vendor_id)->first()->vendor_name }}</p>
                        <p class="text-sm text-gray-600" id="gst_number">{{ $vendor->where('id', $purchase->vendor_id)->first()->gst_number }}</p>
                    </div>
                </div>
        
                <!-- Items Table -->
                <div class="overflow-x-auto mt-6">
                    <table class="w-full text-sm border border-gray-300 rounded-lg overflow-hidden mb-10 main_table">
                        <thead class="bg-[#062242] text-white">
                            <tr>
                                <th class="p-3 border">#</th>
                                <th class="p-3 border">Description</th>
                                <th class="p-3 border">HSN</th>
                                <th class="p-3 border">Qty</th>
                                <th class="p-3 border">Price</th>
                                <th class="p-3 border" id="cgst-hd">CGST</th>
                                <th class="p-3 border" id="sgst-hd">SGST</th>
                                <th class="p-3 border" id="igst-hd">IGST</th>
                                <th class="p-3 border">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (json_decode($purchase->item_details, true) as $index => $item)
                                @php $product = $products->where('id', $item['product_id'])->first(); @endphp
                                <tr class="even:bg-gray-50">
                                    <td class="p-3 border text-center">{{ $index + 1 }}</td>
                                    <td class="p-3 border">
                                        <strong>{{ $product->product_name ?? 'Unknown' }}</strong><br>
                                        <span class="text-xs text-gray-500">Barcode: {{ $item['barcode'] ?? '—' }}</span>
                                    </td>
                                    <td class="p-3 border text-center">{{ $product->hsn_code ?? '—' }}</td>
                                    <td class="p-3 border text-center">{{ $item['quantity'] }}</td>
                                    <td class="p-3 border text-right">₹{{ number_format($item['price'], 2) }}</td>
                                    <td class="p-3 border text-right cgst_td">
                                        ₹{{ number_format($item['cgst'], 2) }}
                                        <span class="block text-xs text-gray-500">({{ number_format($item['tax'] / 2, 2) }}%)</span>
                                    </td>
                                    <td class="p-3 border text-right sgst_td">
                                        ₹{{ number_format($item['sgst'], 2) }}
                                        <span class="block text-xs text-gray-500">({{ number_format($item['tax'] / 2, 2) }}%)</span>
                                    </td>
                                    <td class="p-3 border text-right igst_td">
                                        ₹{{ number_format($item['igst'], 2) }}
                                        <span class="block text-xs text-gray-500">({{ number_format($item['tax'], 2) }}%)</span>
                                    </td>
                                    <td class="p-3 border text-right">₹{{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="font-semibold bg-gray-100">
                                <td colspan="5" class="p-3 border text-right">Total</td>
                                <td class="p-3 border text-right cgst_td">₹<span class="total_cgst">0</span></td>
                                <td class="p-3 border text-right sgst_td">₹<span class="total_sgst">0</span></td>
                                <td class="p-3 border text-right igst_td">₹<span class="total_igst">0</span></td>
                                <td class="p-3 border text-right">₹{{ number_format($purchase->subtotal, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        
                <!-- Tax Breakdown -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4 shadow bg-gray-50">
                        <h3 class="text-lg font-bold text-[#062242] mb-4 border-b pb-2">Tax Breakdown</h3>
                        <div class="flex justify-between py-1 cgst_td">
                            <span>CGST</span>
                            <span>₹<span class="total_cgst">{{ number_format($purchase->total_cgst ?? 0, 2) }}</span></span>
                        </div>
                        <div class="flex justify-between py-1 sgst_td">
                            <span>SGST</span>
                            <span>₹<span class="total_sgst">{{ number_format($purchase->total_sgst ?? 0, 2) }}</span></span>
                        </div>
                        <div class="flex justify-between py-1 igst_td">
                            <span>IGST</span>
                            <span>₹<span class="total_igst">{{ number_format($purchase->total_igst ?? 0, 2) }}</span></span>
                        </div>
                        <div class="flex justify-between py-1 border-t mt-2 pt-2 font-semibold">
                            <span>Total Tax</span>
                            <span>₹{{ number_format($purchase->total_tax, 2) }}</span>
                        </div>
                    </div>
        
                    <!-- Payment Summary -->
                    <div class="border rounded-lg p-4 shadow bg-gray-50">
                        <h3 class="text-lg font-bold text-[#062242] mb-4 border-b pb-2">Payment Summary</h3>
                        <div class="flex justify-between py-1">
                            <span>Taxable Value</span>
                            <span>₹{{ number_format($purchase->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>Tax Amount</span>
                            <span>₹{{ number_format($purchase->total_tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold border-t mt-2 pt-2">
                            <span>Total Invoice Value</span>
                            <span>₹{{ number_format($purchase->grand_total, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span>Paid Amount</span>
                            <span>₹{{ number_format($purchase->paid_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-1 text-red-600 font-semibold">
                            <span>Balance Due</span>
                            <span>₹{{ number_format($purchase->balance, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Button -->
            <div class="text-center mt-12">
                <button onclick="printInvoice()" class="bg-[#062242] hover:bg-[#03182d] text-white px-8 py-3 rounded-lg shadow-md font-semibold">
                    Print Invoice
                </button>
            </div>
        </div>
        
    </x-pagestructure>
</x-layout>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

        function printInvoice() {
            const printContents = document.getElementById('invoice').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }


    $(document).ready(function () {
        var getGst = $('#gst_number').text().trim();
        let stateCode = getGst.substring(0, 2);

        if (stateCode === '33') {
            $('.gst_type').val('Intrastate GST');
            $('#igst-hd').addClass('hidden');
            $('#sgst-hd, #cgst-hd').removeClass('hidden');
            $('.igst_td').addClass('hidden');
            $('.sgst_td, .cgst_td').removeClass('hidden');
        } else {
            $('.gst_type').val('Interstate GST');
            $('#igst-hd').removeClass('hidden');
            $('#sgst-hd, #cgst-hd').addClass('hidden');
            $('.igst_td').removeClass('hidden');
            $('.sgst_td, .cgst_td').addClass('hidden');
        }
    });

    $(document).ready(function () {
    var cgstTotal = 0;
    var sgstTotal = 0;
    var igstTotal = 0;

    $('.main_table tbody tr').each(function () {
        var cgstText = $(this).find('td:nth-child(6)').text().trim();
        var sgstText = $(this).find('td:nth-child(7)').text().trim();
        var igstText = $(this).find('td:nth-child(8)').text().trim();
        

        var cgstValue = parseFloat(cgstText.replace('%', '').replace('₹', '').replace(/,/g, '')) || 0;
        var sgstValue = parseFloat(sgstText.replace('%', '').replace('₹', '').replace(/,/g, '')) || 0;
        var igstValue = parseFloat(igstText.replace('%', '').replace('₹', '').replace(/,/g, '')) || 0;

        cgstTotal += cgstValue;
        sgstTotal += sgstValue;
        igstTotal += igstValue;

    });
    
    $('.total_cgst').text(cgstTotal);
    $('.total_sgst').text(sgstTotal);
    $('.total_igst').text(igstTotal);

});
</script>
