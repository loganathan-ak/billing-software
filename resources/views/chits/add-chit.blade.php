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

            <div class="flex justify-end">
                <a href="/chits" class="inline-block bg-[#062242] text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                    ← Back
                </a>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form method="POST" action="{{ route('chits.store') }}" class="space-y-6 p-6 bg-white rounded shadow-md">
                @csrf
            
                {{-- Chit Type Toggle --}}
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="chit_type" value="new" onchange="toggleChitType()" checked>
                        <span class="font-semibold">Start New Chit</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="radio" name="chit_type" value="payment" onchange="toggleChitType()">
                        <span class="font-semibold">Pay Installment</span>
                    </label>
                </div>
            
                {{-- New Chit Section --}}
                <div id="new_chit_section">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Chit Number</label>
                            <input type="text" name="chit_number" value="{{ $newChitNumber }}" readonly
                                   class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Customer*</label>
                            <select id="new_customer_id" name="customer_id"
                                    class="w-full p-2 border border-gray-300 rounded bg-white" >
                                <option value="">Select a customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            data-contact="{{ $customer->contact_number }}"
                                            data-email="{{ $customer->email }}"
                                            data-address="{{ $customer->address }}">
                                        {{ $customer->customer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Contact Number</label>
                            <input type="text" name="contact_number" id="new_contact_number" class="w-full p-2 border border-gray-300 rounded" placeholder="Optional">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Email</label>
                            <input type="email" name="email" id="new_email" class="w-full p-2 border border-gray-300 rounded" placeholder="Optional">
                        </div>
            
                        <div class="md:col-span-2">
                            <label class="block font-semibold mb-1">Address</label>
                            <textarea name="address" id="new_address" class="w-full p-2 border border-gray-300 rounded" rows="2" placeholder="Optional"></textarea>
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Chit Start Date*</label>
                            <input type="date" name="start_date" class="w-full p-2 border border-gray-300 rounded" >
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Monthly Amount*</label>
                            <input type="number" name="monthly_amount" class="w-full p-2 border border-gray-300 rounded" >
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Total Months*</label>
                            <input type="number" name="total_months" value="12" class="w-full p-2 border border-gray-300 rounded" >
                        </div>
                        
                        <div>
                            <label class="block font-semibold mb-1">Discount(percent)*</label>
                            <input type="number" name="discount-percent" class="w-full p-2 border border-gray-300 rounded">
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Description</label>
                            <input type="text" name="description" class="w-full p-2 border border-gray-300 rounded" placeholder="Optional">
                        </div>
                    </div>
                </div>
            
                {{-- Payment Section --}}
                <div id="payment_section" class="hidden">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Chit Number*</label>
                            <input type="text" name="pay_chit_number" id="pay_chit_number" class="w-full p-2 border border-gray-300 rounded">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Customer*</label>
                            <input type="text" class="w-full p-2 border border-gray-300 rounded" name="pay_customer_name">
                            <input type="hidden" name="pay_customer_id" class="w-full p-2 border border-gray-300 rounded">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Contact Number</label>
                            <input type="text" name="pay_contact_number" id="pay_contact_number" class="w-full p-2 border border-gray-300 rounded" placeholder="Optional">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Email</label>
                            <input type="email" name="pay_email" id="pay_email"
                                   class="w-full p-2 border border-gray-300 rounded" placeholder="Optional">
                        </div>
            
                        <div class="md:col-span-2">
                            <label class="block font-semibold mb-1">Address</label>
                            <textarea name="pay_address" id="pay_address"
                                      class="w-full p-2 border border-gray-300 rounded" rows="2"
                                      placeholder="Optional"></textarea>
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Payment Date*</label>
                            <input type="date" name="payment_date" class="w-full p-2 border border-gray-300 rounded">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Amount Paid*</label>
                            <input type="number" name="amount_paid" class="w-full p-2 border border-gray-300 rounded">
                        </div>
            
                        <div>
                            <label class="block font-semibold mb-1">Month Number*</label>
                            <input type="number" name="month_number" class="w-full p-2 border border-gray-300 rounded">
                        </div>

                                {{-- Due Status for Payment --}}
                        <div>
                            <label class="block font-semibold mb-1">Due Status</label>
                            <select name="due_status" class="w-full p-2 border border-gray-300 rounded bg-white" >
                                <option value="pending" selected>Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

                    </div>
                </div>
            
                <div class="pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                        Submit
                    </button>
                </div>
            </form>
            
        </div>
    </x-pagestructure>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function toggleChitType() {
        let type = $('input[name="chit_type"]:checked').val();
        $('#new_chit_section').toggle(type === 'new');
        $('#payment_section').toggle(type === 'payment');
    }

    $('#new_customer_id').on('change', function () {
        let opt = $(this).find('option:selected');
        $('#new_contact_number').val(opt.data('contact'));
        $('#new_email').val(opt.data('email'));
        $('#new_address').val(opt.data('address'));
    });

    $('#pay_customer_id').on('change', function () {
        let opt = $(this).find('option:selected');
        $('#pay_contact_number').val(opt.data('contact'));
        $('#pay_email').val(opt.data('email'));
        $('#pay_address').val(opt.data('address'));
    });

    $(document).ready(function () {
    $('#pay_chit_number').on('input', function () {
   
        let chitNumber = $(this).val().trim();
        if (chitNumber.length >= 7) {
            console.log(chitNumber); // debug

            $.ajax({
                url: `/get-chit-details/${chitNumber}`,
                type: 'GET',
                success: function (response) {
                    console.log(response); // debug
                    if (response.success) {
                        $('input[name="pay_customer_id"]').val(response.customer.id);
                        $('input[name="pay_customer_name"]').val(response.customer.customer_name);
                        $('input[name="pay_contact_number"]').val(response.customer.contact_number);
                        $('input[name="pay_email"]').val(response.customer.email);
                        $('textarea[name="pay_address"]').val(response.customer.address);
                        $('input[name="amount_paid"]').val(response.chit.monthly_amount);
                        $('input[name="month_number"]').val(response.next_month_number);
                    } else {
                        alert(response.message || 'Chit not found.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }
    });
});

</script>
    
    
</x-layout>
