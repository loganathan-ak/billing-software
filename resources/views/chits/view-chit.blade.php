<x-layout>
    <x-pagestructure>
<div class="bg-gray-100 flex justify-center items-center min-h-screen p-6 box-border">
    <div class="max-w-[1000px] w-full mx-auto p-10 bg-white rounded-2xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold text-center text-gray-900 mb-10">Chit Details</h1>

        <div class="text-2xl font-bold text-gray-800 border-b-2 border-gray-200 mb-6 pb-2">General Information</div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 mb-6">
        <div>
            <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Chit Number:</span>
            <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $chit->chit_number }}</div>
        </div>

        <div>
            <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Customer ID:</span>
            <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $customers->where('id', $chit->customer_id)->first()->customer_name ?? 'Unknown' }}</div>
        </div>

        <div>
            <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Overall Chit Status:</span>
            <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ ucfirst(str_replace('_', ' ', $chit->chit_status)) }}</div>
            <p class="text-xs text-gray-500 mt-1 leading-snug">Status of the chit</p>
        </div>
    </div>

    <!-- New Chit Fields -->
    <div id="new_chit_fields_display">
        <div class="text-2xl font-bold text-gray-800 border-b-2 border-gray-200 mb-6 pb-2">Chit Plan Details</div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-x-6 gap-y-4 mb-6">
            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Start Date:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $chit->start_date }}</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Only for new chit</p>
            </div>

            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Monthly Amount:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">₹{{ number_format($chit->monthly_amount, 2) }}</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Only for new chit</p>
            </div>

            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Total Months:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $paidmonths->count() }} / {{ $chit->total_months }}</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Only for new chit</p>
            </div>

            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Total Paid Amount:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">
                 ₹{{ number_format($paidmonths->sum('amount_paid'), 2) }}
                </div>
            </div>


            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Current Wallet Balance:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $chit->discount_percent ?? 'N/A' }}%</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Optional discount percentage for new chit</p>
            </div>

            <div>
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Discount Percentage:</span>
                <div class="text-base text-gray-700 p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $chit->discount_percent ?? 'N/A' }}%</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Optional discount percentage for new chit</p>
            </div>

            <div class="col-span-full">
                <span class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Description:</span>
                <div class="text-base text-gray-700 p-3 whitespace-pre-wrap bg-gray-50 rounded-lg border border-gray-200">{{ $chit->description ?? 'N/A' }}</div>
                <p class="text-xs text-gray-500 mt-1 leading-snug">Optional text for new chit</p>
            </div>
        </div>
    </div>

        <div class="text-2xl font-bold text-gray-800 border-b-2 border-gray-200 mb-6 pb-2">Payment History</div>
        <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200">
            <table class="w-full border-collapse bg-white rounded-lg">
                <thead class="bg-gray-50 text-gray-700 text-sm uppercase font-semibold tracking-wider">
                    <tr>
                        <th class="p-4 text-left border-b border-gray-200">Month No.</th>
                        <th class="p-4 text-left border-b border-gray-200">Payment Date</th>
                        <th class="p-4 text-left border-b border-gray-200">Amount Paid</th>
                        <th class="p-4 text-left border-b border-gray-200">Due Status</th>
                    </tr>
                </thead>
                <tbody id="payment_records_tbody" class="text-sm text-gray-800">
                    @forelse($paidmonths as $payment)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="p-4">{{ $payment->month_number }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</td>
                            <td class="p-4">₹{{ number_format($payment->amount_paid, 2) }}</td>
                            <td class="p-4">
                                @if($payment->is_due)
                                    <span class="text-red-600 font-medium">Due</span>
                                @else
                                    <span class="text-green-600 font-medium">Paid</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">No payment records found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
</div>


</div>
    </x-pagestructure>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    
</x-layout>
