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
           <div class="mt-5">
            @if(Session::has('added'))
            <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800 shadow">
                {{ Session::get('added') }}
            </div>
        @endif
      </div>

   

      <form action="/create_purchase" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-end">
          <a href="/purchases" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
              ← Back
          </a>
      </div>
        @csrf
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Stock Purchase Entry</h2>
        <p class="hidden" id="admin_gst">{{$admingst}}</p>
        <!-- Grid Inputs -->       
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Invoice Date -->
          <div>
            <label for="invoice_date" class="block text-sm font-medium text-gray-600">Invoice Date</label>
            <input type="date" id="invoice_date" name="invoice_date"
              class="w-full p-2 border border-gray-300 bg-white rounded-md" value="{{ old('invoice_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
          </div>
      
          <!-- Invoice Number -->
          <div>
            <label for="invoice_number" class="block text-sm font-medium text-gray-600">Invoice Number</label>
            <input type="text" id="invoice_number" name="invoice_number" placeholder="Enter invoice number"
              class="w-full p-2 border border-gray-300 bg-white rounded-md" required>
          </div>
      
          <!-- Vendor -->
          <div>
            <label for="vendor_id" class="block text-sm font-medium text-gray-600">Vendor</label>
            <select id="vendor_id" name="vendor_id" class="w-full p-2 border border-gray-300 bg-white rounded-md" required>
              <option value="">Select vendor...</option>
              @foreach($vendors as $vendor)
              <option value="{{$vendor->id}}">{{$vendor->vendor_name}}</option>
              @endforeach
            </select>
            <button type="button" onclick="vendorModal()"
              class="font-medium text-sm text-blue-400 w-[150px]">+ Add New Vendor</button>
          </div>

          <div>
            <label for="contact_person" class="block text-sm font-medium text-gray-600">Contact Person</label>
            <input type="text" id="contact_person" name="contact_person" placeholder="Enter Contact Person"
              class="w-full p-2 border border-gray-300 bg-white rounded-md"  readonly>
          </div>
  
          <div>
            <label for="contact_number" class="block text-sm font-medium text-gray-600">Contact Number</label>
            <input type="text" id="contact_number" name="contact_number" placeholder="Enter Contact number"
              class="w-full p-2 border border-gray-300 bg-white rounded-md"  readonly>
          </div>
  
          <div>
            <label for="gst_number" class="block text-sm font-medium text-gray-600">GST Number</label>
            <input type="text" id="gst_number" name="gst_number" placeholder="Enter GST number"
              class="w-full p-2 border border-gray-300 bg-white rounded-md"  readonly>
          </div>


        </div>

        
      
        <!-- Items Table -->
        <div class="w-full mt-6">
          <label class="block mb-3 font-semibold text-gray-700">Items</label>
      
           <!-- Header -->
           <div class="grid grid-cols-13 gap-2 font-semibold text-gray-600 text-sm mb-2">
            <div class="col-span-2">Name</div>
            <div class="col-span-2">Barcode</div>
            <div class="col-span-1">Qty</div>
            <div class="col-span-1">Price per unit</div>
            <div class="col-span-1">Tax %</div>
            <div class="col-span-2">Total</div>
            <div class="col-span-1 hidden" id="cgst-hd">CGST</div>
            <div class="col-span-1 hidden" id="sgst-hd">SGST</div>
            <div class="col-span-1 hidden" id="igst-hd">IGST</div>
            <div class="col-span-1">Action</div>
          </div>
      
          <!-- Repeater Content -->
          <div id="invoice-repeater" class="space-y-2"></div>
      
          <!-- Add Line Button -->
          <div class="flex items-center gap-4 mt-4">
            <button type="button" class="bg-gray-200 text-black px-3 py-1 rounded-md" onclick="invoiceRepeater()">
              + Add line
            </button>
            <button type="button" onclick="openItemModal()" class="font-medium text-sm text-blue-400">
              + Add New Item
            </button>
          </div>
        </div>
      
        <!-- Description (Full width) -->
        <div class="mt-6 w-full">
          <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
          <textarea name="description" id="description" rows="3"
            class="p-2 w-full border border-gray-300 bg-white rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Payment Status -->
          <div>
             <label for="payment_status" class="block text-sm font-medium text-gray-600">Payment <span class="font-bold underline">S</span>tatus</label>
             <select name="payment_status" id="payment_status" required class="w-full p-2 border border-gray-300 bg-white rounded-md" onchange="toggleBalanceField()">
               <option value="">Select status...</option>
               <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
               <option value="Unpaid" {{ old('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
             </select>
           </div>

           <!-- Paid Amount -->
           <div id="paid_amount_div">
             <label for="paid_amount" class="block text-sm font-medium text-gray-600">Paid <span class="font-bold underline">A</span>mount</label>
             <input type="number" name="paid_amount" id="paid_amount" step="0.01" value="{{ old('paid_amount') }}" class="w-full p-2 border border-gray-300 bg-white rounded-md" oninput="updateBalance()" />
           </div>

           <!-- Balance -->
           <div id="balance_div">
             <label for="balance" class="block text-sm font-medium text-gray-600"><span class="font-bold underline">B</span>alance</label>
             <input type="number" name="balance" id="balance" step="0.01" value="{{ old('balance') }}" class="w-full p-2 border border-gray-300 bg-white rounded-md" readonly />
           </div>
     </div>
      
        <!-- Totals (Horizontal Row) -->
        <div class="mt-6 flex justify-center text-base text-gray-800">
          <div class="flex gap-12 items-center">

            <!-- Subtotal -->
            <div class="flex flex-col items-center">
              <span class="text-lg text-gray-600">Subtotal</span>
              <span id="subtotal" class="text-lg font-semibold text-blue-600">₹0.00</span>
              <input type="hidden" name="subtotal" id="input_subtotal">
            </div>

            <!-- Total Tax -->
            <div class="flex flex-col items-center">
              <span class="text-lg text-gray-600">Total Tax</span>
              <span id="tax_total" class="text-lg font-semibold text-blue-600">₹0.00</span>
              <input type="hidden" name="total_tax" id="input_tax_total">
            </div>

            <!-- Grand Total -->
            <div class="flex flex-col items-center">
              <span class="text-lg text-gray-600">Grand Total</span>
              <span id="grand_total" class="text-xl font-bold text-green-700">₹0.00</span>
              <input type="hidden" name="grand_total" id="input_grand_total">
            </div>

          </div>
        </div>
        
      
        <!-- Submit Button -->
        <div class="text-right mt-4">
          <button type="submit"
            class="inline-flex items-center px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow transition-all">
            Save Purchase
          </button>
        </div>
      </form>
      
        
        
          

    </x-pagestructure>  

<x-popups />

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).on('change', '#vendor_id', function() {
    var vendorId = $(this).val();

    if (vendorId) {
        $.ajax({
            url: '/vendor/' + vendorId, // Ensure this URL is correct in routes
            method: 'GET',
            success: function(response) {
                // If response contains GST number, update the GST field
                if (response.gst_number) {
                    
                  
                  $('#gst_number').val(response.gst_number);
                  $('#contact_number').val(response.contact_number);
                  $('#contact_person').val(response.contact_person);
                    var getFirstTwoletter = response.gst_number;
                    let adminGstTwoletter = $('#admin_gst').text();
                    let vendorGst = getFirstTwoletter.substring(0, 2);
                    let adminGst = adminGstTwoletter.substring(0, 2);

                    if (vendorGst === adminGst) {
                    $('.gst_type').val('Intrastate GST');

                    // Show SGST and CGST, hide IGST
                    $('#igst-hd').addClass('hidden');
                    $('#sgst-hd').removeClass('hidden');
                    $('#cgst-hd').removeClass('hidden');

                    // Toggle input fields
                    $('.igst_input').addClass('hidden');
                    $('.sgst_input').removeClass('hidden');
                    $('.cgst_input').removeClass('hidden');
                } else {
                    $('.gst_type').val('Interstate GST');

                    // Show IGST, hide SGST and CGST
                    $('#igst-hd').removeClass('hidden');
                    $('#sgst-hd').addClass('hidden');
                    $('#cgst-hd').addClass('hidden');

                    // Toggle input fields
                    $('.igst_input').removeClass('hidden');
                    $('.sgst_input').addClass('hidden');
                    $('.cgst_input').addClass('hidden');
                }



                } else {
                    $('#gst_number').val(''); // Clear the field if no GST found
                }
            },
            error: function(xhr) {
                console.log('Error:', xhr.responseText); // Debug the error
            }
        });
    } else {
        $('#gst_number').val(''); // Clear the GST number if no customer selected
    }
});

  
$('#addVendorForm').on('submit', function(e) {
        e.preventDefault(); // prevent normal form submission

        let formData = $(this).serialize();

        $.ajax({
            url: '/add-vendor-pop',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('Vendor added successfully');

                  // Add the new vendor to the dropdown
        const newOption = new Option(response.vendor_name, response.id, true, true);
        $('#vendor_id').append(newOption).trigger('change');
        $('#vendor_id option[value=""]').prop('selected', true);

                // optionally close modal or reset form
                $('#addVendorForm')[0].reset();
                closeVendorModal(); // your existing function
            },
            error: function(xhr) {
                // Show validation errors if needed
                alert('Error: ' + xhr.responseJSON?.message ?? 'Something went wrong');
                console.log(xhr.responseText);
            }
        });
    });


    $('#addItemForm').on('submit', function(e) {
    e.preventDefault(); // prevent normal form submission

    let formData = $(this).serialize();

    $.ajax({
        url: '/add-item-pop', // ✅ update this if your actual item endpoint is different
        type: 'POST',
        data: formData,
        success: function(response) {
            alert('Item added successfully');
            invoiceRepeater();

            // ✅ Append new item to item dropdown (adjust selector if needed)
            const newOption = new Option(response.item_name, response.id);
            $('.select_item').append(newOption);
            

            // ✅ Reset form and close modal
            $('#addItemForm')[0].reset();
            closeItemModal(); // or whatever modal-closing function you're using
        },
        error: function(xhr) {
            alert('Error: ' + (xhr.responseJSON?.message ?? 'Something went wrong'));
            console.log(xhr.responseText);
        }
    });
});


  function vendorModal() {
      document.getElementById('vendorModal').classList.remove('hidden');
  }

  function closeVendorModal() {
      document.getElementById('vendorModal').classList.add('hidden');
  }


  function openItemModal() {
        document.getElementById('itemModal').classList.remove('hidden');
    }

    function closeItemModal() {
        document.getElementById('itemModal').classList.add('hidden');
    }


    function invoiceRepeater() {
        $('#invoice-repeater').append(`
        <div class="grid grid-cols-13 gap-2 mt-2">
    <div class="col-span-2">
        <select name="product[]" class="p-2 border rounded-md w-full select_item">
            <option value="">Select Product</option>
            @foreach ($items as $item)
                <option value="{{ $item->id }}">{{ $item->product_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-span-2">
        <input type="text" name="barcode[]" class="p-2 border rounded-md w-full barcode">
    </div>
    <div class="col-span-1">
        <input type="number" name="quantity[]" class="p-2 border rounded-md w-full quantity" min="0">
    </div>
    <div class="col-span-1">
        <input type="number" name="price[]" class="p-2 border rounded-md w-full price">
    </div>
    <div class="col-span-1">
        <input type="number" name="tax[]" class="p-2 border rounded-md w-full tax">
    </div>
    <div class="col-span-2">
        <input type="number" name="total[]" class="p-2 border rounded-md w-full total" >
    </div>
    <div class="col-span-1 cgst_input hidden">
        <input type="number" name="cgst[]" step="0.01" class="p-2 border rounded-md w-full cgst " >
    </div>
    <div class="col-span-1 sgst_input hidden">
        <input type="number" name="sgst[]" step="0.01" class="p-2 border rounded-md w-full sgst " >
    </div>
    <div class="col-span-1 igst_input hidden">
        <input type="number" name="igst[]" step="0.01" class="p-2 border rounded-md w-full igst " >
    </div>
    <div class="hidden">
         <input type="text" name="tax_type[]" class="gst_type">
    </div>
    <div class="col-span-1 flex justify-start items-center">
        <button type="button" onclick="removeDiv(this)" class="text-red-600">
             <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
</div>
    `);

    let result = $('#gst_number').val().substring(0, 2);
    let adminGstTwoletter = $('#admin_gst').text();
    let adminGst = adminGstTwoletter.substring(0, 2);

if (result === adminGst) {
  $('.gst_type').val('Intrastate GST');

  // Show SGST and CGST, hide IGST
  $('#igst-hd').addClass('hidden');
  $('#sgst-hd').removeClass('hidden');
  $('#cgst-hd').removeClass('hidden');

  // Toggle input fields
  $('.igst_input').addClass('hidden');
  $('.sgst_input').removeClass('hidden');
  $('.cgst_input').removeClass('hidden');
} else {
  $('.gst_type').val('Interstate GST');

  // Show IGST, hide SGST and CGST
  $('#igst-hd').removeClass('hidden');
  $('#sgst-hd').addClass('hidden');
  $('#cgst-hd').addClass('hidden');

  // Toggle input fields
  $('.igst_input').removeClass('hidden');
  $('.sgst_input').addClass('hidden');
  $('.cgst_input').addClass('hidden');
}
    
    }

    function removeDiv(button) {
        $(button).closest('.grid').remove();
        calculateAll();
    }




      $(document).ready(function($){

      function updateSubtotal() {
          var subtotal = 0;

          $('.total').each(function() {
              var value = parseFloat($(this).val()) || 0;
              subtotal += value;
          });

          $('#subtotal').text('₹' + subtotal); // Set the subtotal in the span
      }

   function updateTaxTotal() {
    var taxTotal = 0;

    $('.grid').each(function () {
        var row = $(this);
        var quantity = parseFloat(row.find('.quantity').val()) || 0;
        var price = parseFloat(row.find('.price').val()) || 0;
        var taxPercent = parseFloat(row.find('.tax').val()) || 0;

        var baseTotal = quantity * price;
        var taxAmount = baseTotal * (taxPercent / 100);
        var cgstAndsgst = taxAmount / 2;

        // Update CGST and SGST in the same row
        row.find('.cgst').val(cgstAndsgst.toFixed(2));
        row.find('.sgst').val(cgstAndsgst.toFixed(2));
        row.find('.igst').val(taxAmount.toFixed(2));

        taxTotal += taxAmount;
    });

    $('#tax_total').text('₹' + taxTotal.toFixed(2));
}

      function updateGrandTotal() {
          var subtotal = parseFloat($('#subtotal').text().replace('₹', '')) || 0;
          var taxTotal = parseFloat($('#tax_total').text().replace('₹', '')) || 0;

          var grandTotal = subtotal + taxTotal;
          $('#grand_total').text('₹' + grandTotal);
      }

      function updateHiddenInputs() {
        $('#input_subtotal').val(parseFloat($('#subtotal').text().replace('₹', '')) || 0);
        $('#input_tax_total').val(parseFloat($('#tax_total').text().replace('₹', '')) || 0);
        $('#input_grand_total').val(parseFloat($('#grand_total').text().replace('₹', '')) || 0);
      }



      // Product selection (AJAX request)
      $(document).on('change', '.select_item', function() {
          var select = $(this);
          var productId = select.val();

          if (productId) {
              $.ajax({
                  url: '/item/' + productId, // route to your controller
                  method: 'GET',
                  success: function(response) {
                      // find the current row
                      var row = select.closest('.grid');
                      console.log(response);

                      // fill the corresponding fields (price, tax)
                      row.find('.barcode').val(response.barcode);
                      row.find('.price').val(response.buying_price);
                      row.find('.tax').val(response.tax);
                      updateRowTotal(row); // Ensure totals are updated immediately
                  },
                  error: function(xhr) {
                      console.log('Error:', xhr.responseText);
                  }
              });
          }
      });

      // Calculate total when quantity or price is changed
      $(document).on('input', '.quantity, .price', function() {
          var row = $(this).closest('.grid');
          var quantity = parseFloat(row.find('.quantity').val()) || 0;
          var price = parseFloat(row.find('.price').val()) || 0;

          // Calculate total without tax
          var total = quantity * price;

          // Set the total value in the total input
          row.find('.total').val(total); // Round to 2 decimals
      });

      // Adjust price if total is changed (allow for manual override)
      $(document).on('input', '.total', function() {
          var row = $(this).closest('.grid');
          var quantity = parseFloat(row.find('.quantity').val()) || 0;
          var total = parseFloat($(this).val()) || 0;

          if (quantity === 0) {
              row.find('.price').val(0); // or leave blank
              return;
          }

          var price = total / quantity;
          row.find('.price').val(price); // Rounds to 2 decimal places
      });

      // Update totals when any input changes (quantity, price, tax, or total)
      $(document).on('input', '.quantity, .price, .tax, .total', function() {
          var row = $(this).closest('.grid');
          updateSubtotal();
          updateTaxTotal();
          updateGrandTotal();
          updateHiddenInputs();

          var grandTotal = parseFloat($('#grand_total').text().replace('₹', '')) || 0;
          $('#paid_amount').val(grandTotal);
      });

      });


      // This should be outside of $(document).ready()
    // This should be outside of $(document).ready()
    function toggleBalanceField() {
    var paymentStatus = $('#payment_status').val();

    if (paymentStatus === 'Paid') {
        $('#paid_amount_div').show();
        $('#balance_div').show();
        $('#balance').prop('readonly', true);
        $('#balance').val('');
    } else if (paymentStatus === 'Unpaid') {
        $('#paid_amount_div').hide();
        $('#balance_div').hide();
        var grandTotal = parseFloat($('#grand_total').text().replace('₹', '')) || 0;
        $('#balance').val(grandTotal.toFixed(2));
        $('#paid_amount').val(0);
    } else {
        $('#paid_amount_div').hide();
        $('#balance_div').hide();
    }
}

      // Keep this inside document.ready
      $(document).ready(function() {
          toggleBalanceField(); // run on load
          
          $('#paid_amount').on('input', function () {
              updateBalance();
          });
      });

      function updateBalance() {
          var paidAmount = parseFloat($('#paid_amount').val()) || 0;
          var grandTotal = parseFloat($('#grand_total').text().replace('₹', '')) || 0;
          var balance = grandTotal - paidAmount;
          $('#balance').val(balance.toFixed(2));
      }


</script>
</x-layout>
