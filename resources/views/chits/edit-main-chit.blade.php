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

        <form method="POST" action="{{ route('chit.update', $chit->id) }}" class="space-y-6 p-6 bg-white rounded shadow-md">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Chit Number</label>
                    <input type="text" value="{{ $chit->chit_number }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Customer</label>
                    <input type="text" value="{{ $customer->customer_name }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Contact Number</label>
                    <input type="text" value="{{ $customer->contact_number }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" value="{{ $customer->email }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div class="md:col-span-2">
                    <label class="block font-semibold mb-1">Address</label>
                    <textarea class="w-full p-2 border border-gray-300 rounded bg-gray-100" rows="2" readonly>{{ $customer->address }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Chit Start Date</label>
                    <input type="date" value="{{ $chit->start_date}}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Monthly Amount</label>
                    <input type="number" value="{{ $chit->monthly_amount }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Total Months</label>
                    <input type="number" value="{{ $chit->total_months }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Discount (%)</label>
                    <input type="number" value="{{ $chit->discount_percent }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Description</label>
                    <input type="text" value="{{ $chit->description }}" readonly
                        class="w-full p-2 border border-gray-300 rounded bg-gray-100">
                </div>

                <div>
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full p-2 border border-gray-300 rounded bg-white">
                        <option value="in_progress" {{ $chit->status == 'in_progress' ? 'selected' : '' }}>In progress</option>
                        <option value="completed" {{ $chit->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $chit->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="on-hold" {{ $chit->status == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        <!-- Add more statuses if needed -->
                    </select>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded">
                    Update Status
                </button>
            </div>
        </form>

            
        </div>
    </x-pagestructure>
    
    
</x-layout>
