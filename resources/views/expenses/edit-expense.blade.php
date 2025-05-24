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
                <form method='POST' action="/delete-expense">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="expense_id" value="{{$expensedata->id}}"/>
                    <button type="submit"
                    class="h-9  w-[120px] text-red-500 font-medium">
                    Delete
                    </button>
                </form>
                <div class="flex justify-end ">
                    <a href="/expenses" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
                        ← Back
                    </a>
                </div>
            </div>

            <form class="grid gap-5 p-3 min-h-min" action="/update-expenses" method="POST">
              @csrf
              @method('PUT')

              <input type="hidden" name="expense_id" value="{{$expensedata->id}}" />
                <!-- Expense Name -->
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="expense_name" class="text-sm font-medium text-gray-500">Expense Name*</label>
                    <input type="text" name="expense_name" id="expense_name" placeholder="Enter expense name" 
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md" 
                        value="{{$expensedata->expense_name}}" required>
                </div>
            
                <!-- Expense Type -->
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="expense_type" class="text-sm font-medium text-gray-500">Expense Type*</label>
                    <div class="md:col-span-4 lg:col-span-2 w-full">
                        <select name="expense_type" id="expense_type" 
                                class="w-full h-9 px-4 py-2 border border-gray-300 bg-white rounded-md text-sm font-medium text-gray-700">
                            <option value="" disabled selected>Select Expense Type...</option>
                            <option value="Packaging Cost" {{ old('expense_type', $expensedata->expense_type) == "Packaging Cost" ? 'selected' : '' }}>Packaging Cost</option>
                            <option value="Shipping Cost" {{ old('expense_type', $expensedata->expense_type) == "Shipping Cost" ? 'selected' : '' }}>Shipping Cost</option>
                            <option value="Store Rent" {{ old('expense_type', $expensedata->expense_type) == "Store Rent" ? 'selected' : '' }}>Store Rent</option>
                            <option value="Labor Cost" {{ old('expense_type', $expensedata->expense_type) == "Labor Cost" ? 'selected' : '' }}>Labor Cost</option>
                            <option value="Miscellaneous" {{ old('expense_type', $expensedata->expense_type) == "Miscellaneous" ? 'selected' : '' }}>Miscellaneous</option>
                            <option value="transportation" {{ old('expense_type', $expensedata->expense_type) == "transportation" ? 'selected' : '' }}>Transportation</option>
                            <option value="fuel" {{ old('expense_type', $expensedata->expense_type) == "fuel" ? 'selected' : '' }}>Fuel</option>
                            <option value="maintenance" {{ old('expense_type', $expensedata->expense_type) == "maintenance" ? 'selected' : '' }}>Maintenance</option>
                            <option value="salary" {{ old('expense_type', $expensedata->expense_type) == "salary" ? 'selected' : '' }}>Salary</option>
                            <option value="office_supplies" {{ old('expense_type', $expensedata->expense_type) == "office_supplies" ? 'selected' : '' }}>Office Supplies</option>
                            <option value="marketing" {{ old('expense_type', $expensedata->expense_type) == "marketing" ? 'selected' : '' }}>Marketing</option>
                        </select>
                    </div>
                </div>

            
                <!-- Amount -->
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="amount" class="text-sm font-medium text-gray-500">Amount*</label>
                    <input type="number" name="amount" id="amount" placeholder="Enter amount" 
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md" 
                        value="{{$expensedata->amount}}" required>
                </div>
            
                <!-- Expense Beneficiary -->
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="beneficiary_name" class="text-sm font-medium text-gray-500">Expense Beneficiary*</label>
                    <input type="text" name="beneficiary_name" id="beneficiary_name" placeholder="Enter beneficiary name" 
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md" 
                        value="{{$expensedata->beneficiary_name}}" required>
                </div>
            
                <!-- Description (Optional) -->
                <div class="grid md:grid-cols-6 md:gap-2 items-center">
                    <label for="description" class="text-sm font-medium text-gray-500">Description</label>
                    <input type="text" name="description" id="description" placeholder="Enter description (optional)" 
                        class="md:col-span-4 lg:col-span-2 p-2 border border-gray-300 bg-white rounded-md" 
                        value="{{$expensedata->description}}">
                </div>
            
                <!-- Submit and Cancel Buttons -->
                <div class="flex gap-4 mt-4">
                    <button type="submit" class=" bg-blue-500 text-white hover:bg-blue-600 rounded-md h-9 px-4 py-1">
                        Update Expense
                    </button>
                </div>
            </form>
            

        </div>
    </x-pagestructure>
</x-layout>
