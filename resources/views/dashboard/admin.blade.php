@extends('layouts.app')

@section('content')
@php
$ministrySpends = collect([
    (object)[
        'ministry' => 'Women Ministry',
        'description' => 'Community outreach and events',
        'amount' => 120000,
        'date' => '2025-10-05',
    ],
    (object)[
        'ministry' => 'Construction Ministry',
        'description' => 'Church repairs and renovations',
        'amount' => 250000,
        'date' => '2025-10-02',
    ],
    (object)[
        'ministry' => 'Youth Ministry',
        'description' => 'Youth programs and camps',
        'amount' => 90000,
        'date' => '2025-10-08',
    ],
    (object)[
        'ministry' => 'Music Ministry',
        'description' => 'Choir instruments and training',
        'amount' => 60000,
        'date' => '2025-10-04',
    ],
    (object)[
        'ministry' => 'Other',
        'description' => 'Miscellaneous ministry activities',
        'amount' => 40000,
        'date' => '2025-10-06',
    ],
]);
@endphp


@php
$expenses = collect([
    (object)[
        'category' => 'Utilities',
        'description' => 'Electricity bill',
        'amount' => 45000,
        'date' => '2025-10-01',
    ],
    (object)[
        'category' => 'Maintenance',
        'description' => 'Church repairs',
        'amount' => 120000,
        'date' => '2025-10-03',
    ],
    (object)[
        'category' => 'Supplies',
        'description' => 'Office stationery',
        'amount' => 30000,
        'date' => '2025-10-05',
    ],
    (object)[
        'category' => 'Events',
        'description' => 'Community outreach',
        'amount' => 80000,
        'date' => '2025-10-07',
    ],
    (object)[
        'category' => 'Miscellaneous',
        'description' => null,
        'amount' => 20000,
        'date' => '2025-10-09',
    ],
]);
@endphp

<div class="dashboard p-6 bg-gray-100 min-h-screen">

    <h2 class="text-3xl font-bold mb-6 text-green-700">Church Dashboard</h2>

    <!-- Date Filter -->
    <form method="GET" action="{{ route('dashboard.admin') }}" class="mb-6 flex flex-col md:flex-row gap-4 items-end">
        <div class="flex flex-col">
            <label for="from_date" class="mb-1 font-medium">From:</label>
            <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}" class="border rounded px-3 py-2">
        </div>
        <div class="flex flex-col">
            <label for="to_date" class="mb-1 font-medium">To:</label>
            <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <button type="submit" class="bg-green-700 text-white rounded px-5 py-2 hover:bg-green-800 transition">Filter</button>
        </div>
    </form>

    <!-- Top Stats Cards with Gradients & Export -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
        @php
            $stats = [
                ['title'=>'Total Tithes','value'=>$tithes ?? rand(10000,50000),'icon'=>'fas fa-donate','color'=>'from-green-600 to-green-700'],
                ['title'=>'Total Offerings','value'=>$offerings ?? rand(5000,20000),'icon'=>'fas fa-hand-holding-dollar','color'=>'from-green-700 to-green-900'],
                ['title'=>'Total Thanksgiving','value'=>$thanksgiving ?? rand(2000,15000),'icon'=>'fas fa-praying-hands','color'=>'from-yellow-500 to-yellow-800'],
                ['title'=>'Other Income','value'=>$otherIncome ?? rand(2000,15000),'icon'=>'fas fa-money-bill-wave','color'=>'from-gray-500 to-gray-700'],
                ['title'=>'Expenses','value'=>$totalExpenses ?? rand(1000,10000),'icon'=>'fas fa-file-invoice-dollar','color'=>'from-red-600 to-red-800'],
                ['title'=>'Remaining Balance','value'=>($tithes ?? rand(10000,50000))+($offerings ?? rand(5000,20000))+($thanksgiving ?? rand(2000,15000))+($otherIncome ?? rand(2000,15000))-($totalExpenses ?? rand(1000,10000))-($conferenceFund ?? rand(5000,30000)),'icon'=>'fas fa-wallet','color'=>'from-blue-400 to-blue-700'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="text-white rounded-xl shadow-lg p-4 flex flex-col justify-between bg-gradient-to-r {{ $stat['color'] }} relative overflow-hidden">
        <div>
            <h3 class="font-semibold text-base">{{ $stat['title'] }}</h3>
            <p class="text-xl font-bold mt-1">{{ $stat['value'] }} TZS</p>
        </div>

        <!-- Icon and Export Button on the Same Line -->
        <div class="mt-4 flex justify-between items-center">
            <i class="{{ $stat['icon'] }} text-xl"></i>
            <button onclick="exportToExcel('{{ $stat['title'] }}', '{{ $stat['value'] }}')"
                    class="bg-white text-gray-700 rounded px-3 py-1 text-sm hover:bg-gray-100 transition">
                Export Excel
            </button>
        </div>
        </div>


        @endforeach
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Income vs Expenses Bar Chart -->
        <div class="bg-white rounded-xl shadow-lg p-4">
            <h3 class="text-lg font-semibold mb-2 text-green-700">Income vs Expenses</h3>
            <canvas id="financeChart" class="w-full h-48"></canvas>
        </div>

        <!-- Income Distribution Pie -->
        <div class="bg-white rounded-xl shadow-lg p-4 flex flex-col" style="max-height: 450px;">
            <h3 class="text-lg font-semibold mb-2 text-green-700">Income Distribution</h3>
            <div class="flex justify-center items-center flex-grow">
                <canvas id="incomePieChart" class="w-full" style="max-width: 250px; max-height: 250px;"></canvas>
            </div>
            <div id="incomePieLegend" class="mt-2 flex gap-3 flex-wrap justify-center overflow-auto" style="max-height: 80px;"></div>
        </div>
    </div>

    <!-- Monthly Offerings Trend Line Chart -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3 text-green-700">Monthly Offerings Trend</h3>
        <canvas id="trendingChart" class="w-full" style="height:300px;"></canvas>
    </div>


 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Recent Expenses -->
    <div class="bg-white rounded-xl shadow-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-green-700">Recent Expenses</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-3 py-2 text-left text-sm font-medium">#</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Category</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Description</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Amount (TZS)</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($expenses ?? [] as $i => $expense)
                        <tr>
                            <td class="px-3 py-2">{{ $i+1 }}</td>
                            <td class="px-3 py-2">{{ $expense->category }}</td>
                            <td class="px-3 py-2">{{ $expense->description ?? '-' }}</td>
                            <td class="px-3 py-2">{{ number_format($expense->amount, 0, '.', ',') }}</td>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ministry Spend -->
    <div class="bg-white rounded-xl shadow-lg p-4">
        <h3 class="text-lg font-semibold mb-3 text-green-700">Ministry Spend</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-3 py-2 text-left text-sm font-medium">#</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Ministry</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Description</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Amount (TZS)</th>
                        <th class="px-3 py-2 text-left text-sm font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($ministrySpends as $i => $spend)
                        <tr>
                            <td class="px-3 py-2">{{ $i+1 }}</td>
                            <td class="px-3 py-2">{{ $spend->ministry }}</td>
                            <td class="px-3 py-2">{{ $spend->description ?? '-' }}</td>
                            <td class="px-3 py-2">{{ number_format($spend->amount, 0, '.', ',') }}</td>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($spend->date)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Finance Bar Chart
    const financeCtx = document.getElementById('financeChart').getContext('2d');
    new Chart(financeCtx, {
        type: 'bar',
        data: {
            labels: ['Tithes','Offerings','Thanksgiving','Other Income','Expenses','Conference Fund'],
            datasets: [{
                label: 'Amount (TZS)',
                data: [
                    {{ $tithes ?? rand(10000,50000) }},
                    {{ $offerings ?? rand(5000,20000) }},
                    {{ $thanksgiving ?? rand(2000,15000) }},
                    {{ $otherIncome ?? rand(2000,15000) }},
                    {{ $totalExpenses ?? rand(1000,10000) }},
                    {{ $conferenceFund ?? rand(5000,30000) }}
                ],
                backgroundColor: ['#28a745','#157347','#FFC107','#6C757D','#DC3545','#0D6EFD']
            }]
        },
        options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
    });

    // Income Distribution Pie Chart
    const incomeCtx = document.getElementById('incomePieChart').getContext('2d');
    const incomeData = [
        {{ $tithes ?? rand(10000,50000) }},
        {{ $offerings ?? rand(5000,20000) }},
        {{ $thanksgiving ?? rand(2000,15000) }},
        {{ $otherIncome ?? rand(2000,15000) }}
    ];
    const incomeLabels = ['Tithes','Offerings','Thanksgiving','Other Income'];
    const incomeColors = ['#28a745','#157347','#FFC107','#6C757D'];
    new Chart(incomeCtx, {
        type: 'pie',
        data:{labels:incomeLabels,datasets:[{data:incomeData,backgroundColor:incomeColors,borderColor:'#fff',borderWidth:2}]},
        options:{responsive:true,plugins:{legend:{display:false}}}
    });

    const incomeLegend = document.getElementById('incomePieLegend');
    const totalIncome = incomeData.reduce((a,b)=>a+b,0);
    incomeLabels.forEach((label,i)=>{
        const percent = ((incomeData[i]/totalIncome)*100).toFixed(1);
        const item = document.createElement('span');
        item.className="flex items-center gap-2";
        item.innerHTML=`<span style="width:14px;height:14px;background:${incomeColors[i]};border-radius:4px;display:inline-block;"></span><span class="font-medium text-gray-700">${label}</span><span class="text-xs text-gray-500">${percent}%</span>`;
        incomeLegend.appendChild(item);
    });

    // Monthly Offerings Trend Line Chart
  // Monthly Offerings Trend Line Chart (Multiple Lines)
const trendCtx = document.getElementById('trendingChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets:[
            {
                label:'Tithes',
                data:[
                    {{ $janTithes ?? rand(5000,15000) }}, {{ $febTithes ?? rand(5000,15000) }}, {{ $marTithes ?? rand(5000,15000) }},
                    {{ $aprTithes ?? rand(5000,15000) }}, {{ $mayTithes ?? rand(5000,15000) }}, {{ $junTithes ?? rand(5000,15000) }},
                    {{ $julTithes ?? rand(5000,15000) }}, {{ $augTithes ?? rand(5000,15000) }}, {{ $sepTithes ?? rand(5000,15000) }},
                    {{ $octTithes ?? rand(5000,15000) }}, {{ $novTithes ?? rand(5000,15000) }}, {{ $decTithes ?? rand(5000,15000) }}
                ],
                borderColor:'#28a745',
                backgroundColor:'rgba(40,167,69,0.1)',
                tension:0.3,
                fill:true,
                pointBackgroundColor:'#28a745',
                pointRadius:3
            },
            {
                label:'Offerings',
                data:[
                    {{ $janOfferings ?? rand(5000,15000) }}, {{ $febOfferings ?? rand(5000,15000) }}, {{ $marOfferings ?? rand(5000,15000) }},
                    {{ $aprOfferings ?? rand(5000,15000) }}, {{ $mayOfferings ?? rand(5000,15000) }}, {{ $junOfferings ?? rand(5000,15000) }},
                    {{ $julOfferings ?? rand(5000,15000) }}, {{ $augOfferings ?? rand(5000,15000) }}, {{ $sepOfferings ?? rand(5000,15000) }},
                    {{ $octOfferings ?? rand(5000,15000) }}, {{ $novOfferings ?? rand(5000,15000) }}, {{ $decOfferings ?? rand(5000,15000) }}
                ],
                borderColor:'#157347',
                backgroundColor:'rgba(21,115,71,0.1)',
                tension:0.3,
                fill:true,
                pointBackgroundColor:'#157347',
                pointRadius:3
            },
            {
                label:'Thanksgiving',
                data:[
                    {{ $janThanksgiving ?? rand(2000,10000) }}, {{ $febThanksgiving ?? rand(2000,10000) }}, {{ $marThanksgiving ?? rand(2000,10000) }},
                    {{ $aprThanksgiving ?? rand(2000,10000) }}, {{ $mayThanksgiving ?? rand(2000,10000) }}, {{ $junThanksgiving ?? rand(2000,10000) }},
                    {{ $julThanksgiving ?? rand(2000,10000) }}, {{ $augThanksgiving ?? rand(2000,10000) }}, {{ $sepThanksgiving ?? rand(2000,10000) }},
                    {{ $octThanksgiving ?? rand(2000,10000) }}, {{ $novThanksgiving ?? rand(2000,10000) }}, {{ $decThanksgiving ?? rand(2000,10000) }}
                ],
                borderColor:'#FFC107',
                backgroundColor:'rgba(255,193,7,0.1)',
                tension:0.3,
                fill:true,
                pointBackgroundColor:'#FFC107',
                pointRadius:3
            }
        ]
    },
    options:{
        responsive:true,
        plugins:{
            legend:{display:true, position:'top'},
            tooltip:{mode:'index', intersect:false}
        },
        scales:{
            y:{beginAtZero:true},
            x:{display:true}
        }
    }
});


    // Export Function for Cards
    function exportToExcel(title, value) {
        const table = `<table>
            <tr><th>${title}</th></tr>
            <tr><td>${value}</td></tr>
        </table>`;
        const blob = new Blob([table], { type: 'application/vnd.ms-excel' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `${title}.xls`;
        link.click();
        URL.revokeObjectURL(url);
    }
</script>
@endsection
