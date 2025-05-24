<!-- Hidden Popup Modal -->
<div id="vendorModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
  
        <!-- Close Button -->
        <button onclick="closeVendorModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
  
        <!-- Add Vendor Form -->
        <form id="addVendorForm" method="POST"  class="grid gap-4">
            @csrf
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Add Vendor</h2>
  
            <input type="text" name="vendor_name" placeholder="Vendor Name*" class="border p-2 rounded-md" required>
            <input type="text" name="contact_person" placeholder="Contact Person*" class="border p-2 rounded-md" required>
            <input type="text" name="address" placeholder="Address*" class="border p-2 rounded-md" required>
            <input type="text" name="phone" placeholder="Phone*" class="border p-2 rounded-md" required>
            
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is_gst" name="is_gst" class="h-4 w-4">
                <label for="is_gst" class="text-sm text-gray-600">Has GST?</label>
            </div>
            <input type="text" name="gst_number" placeholder="GST Number" class="border p-2 rounded-md" readonly>
  
            <input type="text" name="description" placeholder="Description (optional)" class="border p-2 rounded-md">
  
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeVendorModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Vendor</button>
            </div>
        </form>
    </div>
  </div>







  <!-- Hidden Popup Modal -->
<div id="customerModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">

      <!-- Close Button -->
      <button onclick="closeCustomerModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>

      <!-- Add Customer Form -->
      <form method="POST" id="addCustomerPop" class="grid gap-4">
          @csrf
          <h2 class="text-lg font-semibold text-gray-700 mb-4">Add Customer</h2>

          <input type="text" name="customer_name" placeholder="Customer Name*" class="border p-2 rounded-md" required>
          <input type="text" name="contact_number" placeholder="Contact Number*" class="border p-2 rounded-md" required>
          <input type="text" name="address" placeholder="Address*" class="border p-2 rounded-md" required>
          <input type="email" name="email" placeholder="Email*" class="border p-2 rounded-md" required>
          
          <div class="flex items-center gap-2">
              <input type="checkbox" id="is_gst" name="is_gst" class="h-4 w-4" required>
              <label for="is_gst" class="text-sm text-gray-600">Has GST?</label>
          </div>
          <input type="text" name="gst_number" placeholder="GST Number" class="border p-2 rounded-md" readonly required>

          <input type="text" name="description" placeholder="Description (optional)" class="border p-2 rounded-md">

          <div class="flex justify-end gap-2 mt-4">
              <button type="button" onclick="closeCustomerModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
              <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Customer</button>
          </div>
      </form>
  </div>
</div>
  
  
  <!-- Hidden Popup Modal for Item -->
  <div id="itemModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
  
      <!-- Close Button -->
      <button type="button" onclick="closeItemModal()" 
              class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
  
      <!-- Form -->
      <form method="POST" id="addItemForm" class="grid gap-5 p-3">
        @csrf
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Add Item</h2>

        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="bar_code" class="text-sm font-medium text-gray-500 md:col-span-2">Bar Code</label>
          <input type="text" name="bar_code" id="bar_code" placeholder="Enter bar code"
              class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md"
              value="{{ old('bar_code') }}" required>
      </div>

        <!-- Item Name -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="product_name" class="text-sm font-medium text-gray-500 md:col-span-2">Item Name*</label>
          <input type="text" name="product_name" id="product_name" placeholder="Enter item name"
            class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md" required value="{{ old('product_name') }}">
        </div>

        <!-- Item Name -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="hsn_code" class="text-sm font-medium text-gray-500 md:col-span-2">HSN*</label>
          <input type="text" name="hsn_code" id="hsn_code" placeholder="Enter bar code"
            class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md" required value="{{ old('hsn_code') }}">
        </div>
  
        <!-- Unit -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="unit_id" class="text-sm font-medium text-gray-500 md:col-span-2">Unit*</label>
          <select name="unit_id" id="unit_id" 
            class="w-full p-2 border border-gray-300 bg-white rounded-md md:col-span-4" required>
            <option value="">Select a unit...</option>
            <option value="Piece" {{ old('unit_id') == "Piece" ? 'selected' : '' }}>Piece</option>
            <option value="Dozen" {{ old('unit_id') == "Dozen" ? 'selected' : '' }}>Dozen</option>
            <option value="Set" {{ old('unit_id') == "Set" ? 'selected' : '' }}>Set</option>
            <option value="Bundle" {{ old('unit_id') == "Bundle" ? 'selected' : '' }}>Bundle</option>
          </select>
        </div>

        <!-- Item Name -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="price_per_unit" class="text-sm font-medium text-gray-500 md:col-span-2">Price per unit*</label>
          <input type="text" name="price_per_unit" id="price_per_unit" placeholder="Price per unit"
            class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md" required value="{{ old('price_per_unit') }}">
        </div>

        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="selling_price_per_unit" class="text-sm font-medium text-gray-500 md:col-span-2">Selling Price Per Unit*</label>
          <input type="text" name="selling_price_per_unit" id="selling_price_per_unit" placeholder="Enter Selling unit price"
              class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md"
              value="{{ old('selling_price_per_unit') }}" required>
        </div>
  
        <!-- Tax Type -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="tax_type_id" class="text-sm font-medium text-gray-500 md:col-span-2">Tax Type*</label>
          <select name="tax_type_id" id="tax_type_id" 
            class="w-full p-2 border border-gray-300 bg-white rounded-md md:col-span-4" required>
            <option value="">Select tax type...</option>
            <option value="GST" {{ old('tax_type_id') == "GST" ? 'selected' : '' }}>GST</option>
            <option value="IGST" {{ old('tax_type_id') == "IGST" ? 'selected' : '' }}>IGST</option>
            <option value="Exempt" {{ old('tax_type_id') == "Exempt" ? 'selected' : '' }}>Exempt</option>
          </select>
        </div>
  
        <!-- Tax Percentage -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="tax_percentage" class="text-sm font-medium text-gray-500 md:col-span-2">Tax %*</label>
          <input type="number" name="tax_percentage" id="tax_percentage" placeholder="Enter tax percentage"
            class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md" step="0.01" required
            value="{{ old('tax_percentage') }}">
        </div>
  
        <!-- Description -->
        <div class="grid md:grid-cols-6 md:gap-2 items-center">
          <label for="description" class="text-sm font-medium text-gray-500 md:col-span-2">Description</label>
          <input type="text" name="description" id="description" placeholder="Enter description (optional)"
            class="md:col-span-4 p-2 border border-gray-300 bg-white rounded-md" value="{{ old('description') }}">
        </div>
  
        <!-- Submit Button -->
        <div class="flex justify-end mt-4">
          <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition-all">
            Add Item
          </button>
        </div>
  
      </form>
    </div>
  </div>
