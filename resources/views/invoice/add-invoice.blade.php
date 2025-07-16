<x-layout> 
    <x-pagestructure>
        <style>
          /* Style for the autocomplete dropdown */
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style for each suggestion item */
.ui-menu-item {
    padding: 8px 12px;
    cursor: pointer;
}

.ui-menu-item:hover {
    background-color: #f1f1f1;
}

          </style>

       
        <div class="flex flex-1 flex-col gap-4 p-4">

            @if ($errors->any())
                <ul class="mb-4 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="flex flex-col mt-4">
                @if(Session::has('updated'))
                    <div class="mb-4 rounded-lg bg-blue-100 px-4 py-3 text-sm text-blue-800 shadow">
                        {{ Session::get('updated') }}
                    </div>
                @elseif(Session::has('added'))
                    <div class="mb-4 rounded-lg bg-green-100 px-4 py-3 text-sm text-green-800 shadow">
                        {{ Session::get('added') }}
                    </div>
                @elseif(Session::has('deleted'))
                    <div class="mb-4 rounded-lg bg-red-100 px-4 py-3 text-sm text-red-800 shadow">
                        {{ Session::get('deleted') }}
                    </div>
                @endif
            </div>

            
      <form action="/add-invoice" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-end ">
          <a href="/sales-invoice" class="inline-block bg-[#062242]  text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition duration-200">
              ← Back
          </a>
      </div>
        @csrf
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Sales Invoice</h2>
      
        <!-- Grid Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Invoice Date -->
          <div>
            <label for="invoice_date" class="block text-sm font-medium text-gray-600"><span class="font-bold underline">I</span>nvoice Date</label>
            <input type="date" id="invoice_date" name="invoice_date"
              class="w-full p-2 border border-gray-300 bg-white rounded-md" value="{{ old('invoice_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
          </div>
      
          <!-- Invoice Number -->
          <div>
            <label for="invoice_number" class="block text-sm font-medium text-gray-600">Invoice Number</label>
            <input type="text" id="invoice_number" name="invoice_number" placeholder="Enter invoice number"
              class="w-full p-2 border border-gray-300 bg-white rounded-md" required value="{{$newInvoiceNumber}}" readonly>
          </div>

          <!-- Customer Phone -->
          <div>
            <label for="customer_phone" class="block text-sm font-medium text-gray-600"><span class="font-bold underline">P</span>hone Number</label>
            <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
             placeholder="Enter phone number" class="w-full p-2 border border-gray-300 bg-white rounded-md" required autocomplete="off">

        </div>
      
          <!-- Customer Name -->
            <div>
                <label for="customer_name" class="block text-sm font-medium text-gray-600"><span class="font-bold underline">C</span>ustomer Name</label>
                <input type="text" id="customer_name" name="customer_name"
                    value="{{ old('customer_name') }}"
                    placeholder="Enter customer name"
                    class="w-full p-2 border border-gray-300 bg-white rounded-md" required>
            </div>
            
            
  
            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-600">Payment <span class="font-bold underline">M</span>ethod</label>
                <select name="payment_method" id="payment_method"
                        class="w-full p-2 border border-gray-300 bg-white rounded-md" required>
                <option value="">Select method...</option>
                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                <option value="UPI" {{ old('payment_method') == 'UPI' ? 'selected' : '' }}>UPI</option>
                <option value="Card" {{ old('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                <option value="Cheque" {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="NEFT" {{ old('payment_method') == 'NEFT' ? 'selected' : '' }}>NEFT</option>
                
                </select>
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
            <div class="col-span-2">Price per unit</div>
            <div class="col-span-1">Tax %</div>
            <div class="col-span-2">Total</div>
            <div class="col-span-1">CGST</div>
            <div class="col-span-1">SGST</div>
            <div class="col-span-1">Action</div>
          </div>
      
          <!-- Repeater Content -->
          <div id="invoice-repeater" class="space-y-2"></div>
      
          <!-- Add Line Button -->
          <div class="flex items-center gap-4 mt-4">
            <button type="button" class="bg-gray-200 text-black px-3 py-1 rounded-md" onclick="invoiceRepeater()">
              + Add line
            </button>
            {{-- <button type="button" onclick="openItemModal()" class="font-medium text-sm text-blue-400">
              + Add New Item
            </button> --}}
          </div>
        </div>
      
        <!-- Description (Full width) -->
        <div class="mt-6 w-full">
          <label for="description" class="block text-sm font-medium text-gray-600"><span class="font-bold underline">D</span>escription</label>
          <textarea name="description" id="description" rows="3"
            class="p-2 w-full border border-gray-300 bg-white rounded-md focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
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
                <label for="balance" class="block text-sm font-medium text-gray-600">
                  <span class="font-bold underline">B</span>alance
                </label>
                <input type="number" name="balance" id="balance" step="0.01"
                  value="{{ old('balance') }}"
                  class="w-full p-2 border border-gray-300 bg-white rounded-md" readonly />
              
                <!-- Returned Change Checkbox -->
                <div class="mt-2 flex items-center gap-2">
                  <input type="checkbox" id="return_change" class="h-4 w-4" name="return_change" />
                  <label for="return_change" class="text-sm text-gray-600">Returned change to customer</label>
                </div>
              </div>


              <!-- Discount Percent -->
              <div>
                <label for="discount_percent" class="block text-sm font-medium text-gray-600">Dis<span class="font-bold underline">c</span>ount(%)</label>
                <input type="number" name="discount_percent" id="discount_percent" step="1"  max="100" value="{{ old('discount') }}"
                 class="w-full p-2 border border-gray-300 bg-white rounded-md" oninput="enforceMaxDiscount(this);"/>
              </div>

            <div>
            <label for="wallet_balance" class="block text-sm font-medium text-gray-600">Wallet Balance</label>
            <select name="wallet_balance" id="wallet_balance"
                    class="w-full p-2 border border-gray-300 bg-white rounded-md">
                <option value="">-- Select Balance --</option>
            </select>
            </div>

            <div id="wallet_balance_div"></div>

              
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

            <!-- Discount Amount -->
            <div class="flex flex-col items-center">
                <span class="text-lg text-gray-600">Discount Amount</span>
                <span id="discount_amount" class="text-lg font-semibold text-blue-600">₹0.00</span>
                <input type="hidden" name="discount_amount" id="input_discount_amount">
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
            Submit
          </button>
        </div>
      </form>        
        </div>
    </x-pagestructure>

<x-popups />



</x-layout>



<!-- jQuery and jQuery UI (load at end of body) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>



 <script>

function enforceMaxDiscount(input) {
    if (parseFloat(input.value) > 100) {
        input.value = 100;
    } else if (parseFloat(input.value) < 0) {
        input.value = 0;
    }
}


    $(document).on('change keyup', '.quantity', function () {
        let quantityInput = $(this);
        let quantity = parseFloat(quantityInput.val());
        let row = quantityInput.closest('.grid');
        let stock = parseFloat(row.find('.select_item option:selected').data('stock'));


        if (stock === 0) {
            alert("This Item is not available now");
            quantityInput.val('');
            quantityInput.prop('readonly', true);
            setTimeout(() => {
                quantityInput.prop('readonly', false);
            }, 1500); // allow input again after 1.5 sec
        } else if (quantity > stock) {
            alert("Entered quantity exceeds available stock (" + stock + ").");
            quantityInput.val(''); // reset to max available
        }
    });


$(document).ready(function() {
    $("#customer_phone").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{ route('customers.autocomplete') }}", // You'll create this route
                data: {
                    term: request.term
                },
                success: function(data) {
                    response($.map(data, function(customer) {
                      console.log(customer);
                        return {
                            label: customer.phone + " - " + customer.name,
                            value: customer.phone,
                            id: customer.id,
                            name: customer.name
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#customer_name").val(ui.item.name);
            $("#customer_id").val(ui.item.id); // optional hidden field

            
            // Clear existing wallet balance options
            $("#wallet_balance").empty().append('<option value="">-- Select Balance --</option>');

                        // Append chits to dropdown
            if (ui.item.chits.length > 0) {
                ui.item.chits.forEach(function (chit) {
                    const optionText = `${chit.chit_number} - ₹${chit.wallet_balance ?? 0}`;
                    const optionValue = chit.wallet_balance ?? 0;
                    $("#wallet_balance").append(`<option value="${optionValue}">${optionText}</option>`);
                });
            }

        }
    });
});


  function customerModal() {
      document.getElementById('customerModal').classList.remove('hidden');
  }

  function closeCustomerModal() {
      document.getElementById('customerModal').classList.add('hidden');
  }


  function openItemModal() {
        document.getElementById('itemModal').classList.remove('hidden');
    }

    function closeItemModal() {
        document.getElementById('itemModal').classList.add('hidden');
    }




function invoiceRepeater() {
    $('#invoice-repeater').append(`
   <!-- Form Row -->
<div class="grid grid-cols-13 gap-2 mt-2">
    <div class="col-span-2">
        <select name="product[]" class="p-2 border rounded-md w-full select_item">
            <option value="">Select Product</option>
            @foreach ($items as $item)
                <option value="{{ $item->id }}" data-stock="{{ $item->current_stock }}">{{ $item->product_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-span-2">
        <input type="text" name="barcode[]" class="p-2 border rounded-md w-full barcode">
    </div>
    <div class="col-span-1">
        <input type="number" name="quantity[]" class="p-2 border rounded-md w-full quantity" min="0">
    </div>
    <div class="col-span-2">
        <input type="number" name="price[]" class="p-2 border rounded-md w-full price">
    </div>
    <div class="col-span-1">
        <input type="number" name="tax[]" class="p-2 border rounded-md w-full tax">
    </div>
    <div class="col-span-2">
        <input type="number" name="total[]" class="p-2 border rounded-md w-full total">
    </div>
    <div class="col-span-1">
        <input type="number" name="cgst[]" step="0.01" class="p-2 border rounded-md w-full cgst">
    </div>
    <div class="col-span-1">
        <input type="number" name="sgst[]" step="0.01" class="p-2 border rounded-md w-full sgst">
    </div>
    <div class="col-span-1 flex  items-center">
        <button type="button" onclick="removeDiv(this)" class="text-red-600">
             <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
</div>
`);
}

function removeDiv(button) {
    $(button).closest('.grid').remove();
    calculateAll();
}

jQuery(document).ready(function($) {
    $(document).on('change', '#is_gst', function() {
        const gstInput = $('input[name="gst_number"]');

        if (this.checked) {
            gstInput.prop('readonly', false);
        } else {
            gstInput.val('').prop('readonly', true);
        }
    });
});



$(document).ready(function($){

function updateSubtotal() {
    var subtotal = 0;

    $('.total').each(function() {
        var value = parseFloat($(this).val()) || 0;
        subtotal += value;
    });

    $('#subtotal').text('₹' + subtotal); // Set the subtotal in the span
}

function updateDiscountAmount() {
<<<<<<< HEAD
=======

>>>>>>> 1f18582b3f5bf4bf30959ea505ef9fdb824ac081
    console.log('#discount_amount');
    let discountPercent = parseFloat($("#discount_percent").val()) || 0;
    let subtotal = parseFloat($('#input_subtotal').val()) || 0;

    let discountAmount = (subtotal * discountPercent) / 100;
    discountAmount = discountAmount.toFixed(2);

    // Update the visible span
    $('#discount_amount').text('₹' + discountAmount);

    // Update the hidden input for form submission
    $('#input_discount_amount').val(discountAmount);
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

        taxTotal += taxAmount;
    });

    $('#tax_total').text('₹' + taxTotal.toFixed(2));
}


function updateGrandTotal() {
    var subtotal = parseFloat($('#subtotal').text().replace(/[^\d.-]/g, '')) || 0;
    var taxTotal = parseFloat($('#tax_total').text().replace(/[^\d.-]/g, '')) || 0;

    var discountText = $('#discount_percent').val().replace('%', '').trim(); // "18 % → 18"
    var discountPercent = parseFloat(discountText) || 0;
    var discountAmount = (discountPercent / 100) * subtotal;

    var grandTotal = subtotal + taxTotal - discountAmount;
    grandTotal = Math.max(grandTotal, 0).toFixed(2);

    $('#grand_total').text('₹' + grandTotal);
}



function updateHiddenInputs() {
  $('#input_subtotal').val(parseFloat($('#subtotal').text().replace('₹', '')) || 0);
  $('#input_tax_total').val(parseFloat($('#tax_total').text().replace('₹', '')) || 0);
  $('#input_grand_total').val(parseFloat($('#grand_total').text().replace('₹', '')) || 0);
  $('#input_discount_amount').val(parseFloat($('#discount_amount').text().replace('₹', '')) || 0);
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
                console.log(response.barcode);
                // fill the corresponding fields (price, tax)
                row.find('.barcode').val(response.barcode);
                row.find('.price').val(response.price);
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
$(document).on('input', '.quantity, .price, .tax, .total, #discount_percent', function() {
    var row = $(this).closest('.grid');
    
    updateSubtotal();
    updateTaxTotal();
    updateGrandTotal();
    updateHiddenInputs();
    updateDiscountAmount();
    
});

});



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
     
      function walletAmount(){
          $('#wallet_balance').on('change', function () {
            const selectedBalance = parseFloat($(this).val()) || 0;

            // Update grand total visually
            $('#grand_total').text('₹' + selectedBalance.toFixed(2));

            // Update hidden input field
            $('#input_grand_total').val(selectedBalance.toFixed(2));

        });
      }



  document.addEventListener('keydown', function (e) {
    if (!e.ctrlKey) return;

    // Ctrl + I → Invoice Date
    if (e.key.toLowerCase() === 'i') {
      e.preventDefault();
      const invoiceDate = document.getElementById('invoice_date');
      if (invoiceDate) invoiceDate.focus();
    }

    // Ctrl + N → Invoice Number
    if (e.key.toLowerCase() === 'n') {
      e.preventDefault();
      const invoiceNumber = document.getElementById('invoice_number');
      if (invoiceNumber) invoiceNumber.focus();
    }

    // Ctrl + C → Customer Name
    if (e.key.toLowerCase() === 'c') {
      e.preventDefault();
      const customerName = document.getElementById('customer_name');
      if (customerName) customerName.focus();
    }

    // Ctrl + P → Customer Phone
    if (e.key.toLowerCase() === 'p') {
      e.preventDefault();
      const customerPhone = document.getElementById('customer_phone');
      if (customerPhone) customerPhone.focus();
    }

    // Ctrl + S → Payment Status
    if (e.key.toLowerCase() === 's') {
      e.preventDefault();
      const paymentStatus = document.getElementById('payment_status');
      if (paymentStatus) paymentStatus.focus();
    }

    // Ctrl + M → Payment Method
    if (e.key.toLowerCase() === 'm') {
      e.preventDefault();
      const paymentMethod = document.getElementById('payment_method');
      if (paymentMethod) paymentMethod.focus();
    }

    // Ctrl + A → Paid Amount
    if (e.key.toLowerCase() === 'a') {
      e.preventDefault();
      const paidAmount = document.getElementById('paid_amount');
      if (paidAmount) paidAmount.focus();
    }

    // Ctrl + B → Balance
    if (e.key.toLowerCase() === 'b') {
      e.preventDefault();
      const balance = document.getElementById('balance');
      if (balance) balance.focus();
    }

    // Ctrl + D → Description
    if (e.key.toLowerCase() === 'd') {
      e.preventDefault();
      const description = document.getElementById('description');
      if (description) description.focus();
    }

    if (e.key.toLowerCase() === 'c') {
      e.preventDefault();
      const discount = document.getElementById('discount');
      if (discount) discount.focus();
    }
  });


  $(document).ready(function () {
    const $balanceInput = $('#balance');
    const $paidAmountInput = $('#paid_amount');
    const $returnChangeCheckbox = $('#return_change');

    let originalPaidAmount = parseFloat($paidAmountInput.val()) || 0;

    function updateCheckboxRequirement() {
        const balance = parseFloat($balanceInput.val()) || 0;
        if (balance > 0) {
            $returnChangeCheckbox.prop('required', true).closest('label').show();
        } else {
            $returnChangeCheckbox.prop('required', false).prop('checked', false).closest('label').hide();
        }
    }

    function adjustPaidAmountBasedOnCheckbox() {
        let balance = parseFloat($balanceInput.val()) || 0;

        if ($returnChangeCheckbox.is(':checked') && balance > 0) {
            // Increase paid amount by the overpaid value to make balance zero
            $paidAmountInput.val(originalPaidAmount + balance); // balance is negative, so subtracting a negative adds
            $balanceInput.val(0);
        } else {
            // Restore original paid amount and balance
            $paidAmountInput.val(originalPaidAmount);
            updateBalance(); // You must define this to recalculate balance if needed
        }
    }

    // Save original paid amount on page load
    originalPaidAmount = parseFloat($paidAmountInput.val()) || 0;

    // Events
    $paidAmountInput.on('input', function () {
        originalPaidAmount = parseFloat($(this).val()) || 0;
        updateCheckboxRequirement();
    });

    $returnChangeCheckbox.on('change', function () {
        adjustPaidAmountBasedOnCheckbox();
    });

    // Initial check on page load
    updateCheckboxRequirement();
});




</script>