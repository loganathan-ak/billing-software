<x-layout> 
    <x-pagestructure>
        <div class="flex justify-end m-5">
            <a href="/sales-invoice" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                ← Back
            </a>
        </div>
        
        <style>
            .invoice {
                width: 320px;
                font-size: 12px;
                font-family: 'Courier New', monospace;
                margin: 0 auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                padding: 2px 0;
                text-align: left;
                font-size: 12px;
            }

            .text-right {
                text-align: right;
            }

            hr {
                border: none;
                border-top: 1px dashed #000;
                margin: 5px 0;
            }

            @media print {
                button {
                    display: none;
                }

                body {
                    margin: 0;
                }
            }
        </style>


        <div class="invoice bg-white p-2" id="invoice">
            {{-- Company Info --}}
            @php $admin = \App\Models\User::where('user_role', 'admin')->first(); @endphp
            @if($admin)
                <div class="text-center">
                    <strong>{{ $admin->company_name }}</strong><br>
                    {{ $admin->address }}<br>
                    Ph: {{ $admin->contact_number }}<br>
                    Email: {{ $admin->email }}
                </div>
            @endif

            <hr>

            {{-- Invoice Info --}}
            <div>
                <strong>Invoice No:</strong> {{ $invoice->invoice_number }}<br>
                <strong>Date:</strong> {{ $invoice->invoice_date }}<br>
                <strong>Customer:</strong>
                {{ $customers->where('id', $invoice->customer_id)->first()->customer_name ?? 'Unknown' }}<br>
                <strong>Contact:</strong>
                {{ $customers->where('id', $invoice->customer_id)->first()->contact_number ?? 'Unknown' }}
            </div>

            <hr>

            {{-- Items Table --}}
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th class="text-right">Amt</th>
                </tr>
                </thead>
                <tbody>
                @foreach (json_decode($invoice->item_details, true) as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $getitems->where('id', $item['product_id'])->first()->product_name ?? 'Unknown' }}<br>
                            <small>Qty: {{ $item['quantity'] }} @ ₹{{ number_format($item['price'], 2) }}</small>
                        </td>
                        <td class="text-right">₹{{ number_format($item['total'], 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <hr>

            {{-- Summary --}}
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">₹{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                @if($invoice->discount_percent > 0)
                    <tr>
                        <td>Discount ({{ $invoice->discount_percent }}%)</td>
                        <td class="text-right">-₹{{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <td>CGST + SGST</td>
                    <td class="text-right">₹{{ number_format($invoice->total_tax, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td class="text-right"><strong>₹{{ number_format($invoice->grand_total, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Paid</td>
                    <td class="text-right">₹{{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td><strong>Balance</strong></td>
                    <td class="text-right"><strong>₹{{ number_format($invoice->balance, 2) }}</strong></td>
                </tr>
            </table>

            <hr>

            {{-- Footer --}}
            <div class="text-center">
                Thank you for your purchase!<br>
                {{ \App\Models\User::where('id', $invoice->created_by)->first()->name ?? 'Created By' }}
            </div>

            <div class="text-center" style="margin-top: 10px;">
                <button onclick="printInvoice()"
                        style="padding: 6px 12px; background: #000; color: #fff; border: none; border-radius: 4px;">Print
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