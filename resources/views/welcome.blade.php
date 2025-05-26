<x-layout> 
    <x-pagestructure>
        <x-dashboarddetails :customers="$customers" :vendors="$vendors" :items="$items" :expenses="$expenses"
         :dailydata="$dailyData"/>
    </x-pagestructure>
</x-layout>
<script>
    // Labels (Dates for the last 7 days)
    const labels = @json($dailyData->pluck('date'));

    // Data from backend
    const salesData = @json($dailyData->pluck('sales'));
    const b2bData = @json($dailyData->pluck('b2b'));
    const purchaseData = @json($dailyData->pluck('purchases')); // using for canceled as placeholder

    // Chart Initialization
    new Chart(document.getElementById('order-chart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Sales',
                    data: salesData,
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgb(59 130 246 / .05)',
                    tension: .2
                },
                {
                    label: 'B2B',
                    data: b2bData,
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgb(16 185 129 / .05)',
                    tension: .2
                },
                {
                    label: 'Purchases',
                    data: purchaseData,
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: 'rgb(244, 63, 94)',
                    borderColor: 'rgb(244, 63, 94)',
                    backgroundColor: 'rgb(244 63 94 / .05)',
                    tension: .2
                },
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
