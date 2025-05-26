       // start: Sidebar
       const sidebarToggle = document.querySelector('.sidebar-toggle')
       const sidebarOverlay = document.querySelector('.sidebar-overlay')
       const sidebarMenu = document.querySelector('.sidebar-menu')
       const main = document.querySelector('.main')
       sidebarToggle.addEventListener('click', function (e) {
           e.preventDefault()
           main.classList.toggle('active')
           sidebarOverlay.classList.toggle('hidden')
           sidebarMenu.classList.toggle('-translate-x-full')
       })
       sidebarOverlay.addEventListener('click', function (e) {
           e.preventDefault()
           main.classList.add('active')
           sidebarOverlay.classList.add('hidden')
           sidebarMenu.classList.add('-translate-x-full')
       })

       // end: Sidebar



       // start: Popper
       const popperInstance = {}
       document.querySelectorAll('.dropdown').forEach(function (item, index) {
           const popperId = 'popper-' + index
           const toggle = item.querySelector('.dropdown-toggle')
           const menu = item.querySelector('.dropdown-menu')
           menu.dataset.popperId = popperId
           popperInstance[popperId] = Popper.createPopper(toggle, menu, {
               modifiers: [
                   {
                       name: 'offset',
                       options: {
                           offset: [0, 8],
                       },
                   },
                   {
                       name: 'preventOverflow',
                       options: {
                           padding: 24,
                       },
                   },
               ],
               placement: 'bottom-end'
           });
       })
       document.addEventListener('click', function (e) {
           const toggle = e.target.closest('.dropdown-toggle')
           const menu = e.target.closest('.dropdown-menu')
           if (toggle) {
               const menuEl = toggle.closest('.dropdown').querySelector('.dropdown-menu')
               const popperId = menuEl.dataset.popperId
               if (menuEl.classList.contains('hidden')) {
                   hideDropdown()
                   menuEl.classList.remove('hidden')
                   showPopper(popperId)
               } else {
                   menuEl.classList.add('hidden')
                   hidePopper(popperId)
               }
           } else if (!menu) {
               hideDropdown()
           }
       })

       function hideDropdown() {
           document.querySelectorAll('.dropdown-menu').forEach(function (item) {
               item.classList.add('hidden')
           })
       }
       function showPopper(popperId) {
           popperInstance[popperId].setOptions(function (options) {
               return {
                   ...options,
                   modifiers: [
                       ...options.modifiers,
                       { name: 'eventListeners', enabled: true },
                   ],
               }
           });
           popperInstance[popperId].update();
       }
       function hidePopper(popperId) {
           popperInstance[popperId].setOptions(function (options) {
               return {
                   ...options,
                   modifiers: [
                       ...options.modifiers,
                       { name: 'eventListeners', enabled: false },
                   ],
               }
           });
       }
       // end: Popper




       // start: Chart
    //    new Chart(document.getElementById('order-chart'), {
    //        type: 'line',
    //        data: {
    //            labels: generateNDays(7),
    //            datasets: [
    //                {
    //                    label: 'Sales',
    //                    data: [55, 20, 22, 57, 22, 99, 33],
    //                    borderWidth: 1,
    //                    fill: true,
    //                    pointBackgroundColor: 'rgb(59, 130, 246)',
    //                    borderColor: 'rgb(59, 130, 246)',
    //                    backgroundColor: 'rgb(59 130 246 / .05)',
    //                    tension: .2
    //                },
    //                {
    //                    label: 'B2B',
    //                    data: [40, 40, 40, 40, 40, 40, 40],
    //                    borderWidth: 1,
    //                    fill: true,
    //                    pointBackgroundColor: 'rgb(16, 185, 129)',
    //                    borderColor: 'rgb(16, 185, 129)',
    //                    backgroundColor: 'rgb(16 185 129 / .05)',
    //                    tension: .2  
    //                },
    //                {
    //                    label: 'Canceled',
    //                    data: [10, 0, 22, 0, 22, 0, 33],
    //                    borderWidth: 1,
    //                    fill: true,
    //                    pointBackgroundColor: 'rgb(244, 63, 94)',
    //                    borderColor: 'rgb(244, 63, 94)',
    //                    backgroundColor: 'rgb(244 63 94 / .05)',
    //                    tension: .2
    //                },
    //            ]
    //        },
    //        options: {
    //            scales: {
    //                y: {
    //                    beginAtZero: true
    //                }
    //            }
    //        }
    //    });

       function generateNDays(n) {
           const data = []
           for(let i=0; i<n; i++) {
               const date = new Date()
               date.setDate(date.getDate()-i)
               data.push(date.toLocaleString('en-US', {
                   month: 'short',
                   day: 'numeric'
               }))
           }
           return data
       }

       // end: Chart


 jQuery(document).ready(function(){
   $('#is_gst').change(function() {
   const gstInput = $('input[name="gst_number"]');
   if ($(this).is(':checked')) {
       gstInput.prop('readonly', false);
   } else {
       gstInput.val('').prop('readonly', true);
   }
  });



  function toggleTaxField() {
     if ($('#tax_included').is(':checked')) {
       $('#taxPercentageField').removeClass('hidden');
     } else {
       $('#taxPercentageField').addClass('hidden');
     }
   }

   // Run on page load
   toggleTaxField();

   // Run on checkbox toggle
   $('#tax_included').change(function() {
     toggleTaxField();
   });

 });

 function exportToExcel() {
    var table = document.getElementById('table-product-list');
    var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
    XLSX.writeFile(wb, 'download.xlsx');
}


