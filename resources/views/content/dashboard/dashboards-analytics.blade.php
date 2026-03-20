@php
$configData = Helper::appClasses();
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Dashboard')
@section('vendor-style')
@vite([
'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
'resources/assets/vendor/scss/pages/cards-statistics.scss',
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/swiper/swiper.js'
])
@endsection

@section('content')
<style>
    .sticky-top {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 1020;
    }
    .count {
        display: inline-block;
        transition: all 1s ease-in-out; /* smooth effect */
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* hover effect */
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }
</style>
<div class="row g-2">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex align-items-center justify-content-end gap-2">
        <a href="javascript:;" class="btn btn-sm btn-primary text-white"><i class="mdi mdi-export text-white fs-4 me-2"></i>Export</a>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="row g-2">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
                <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="d-flex justify-content-start align-items-start flex-column">
                            <span class="fw-medium fs-7 text-dark">
                                Total SRV
                            </span>
                            <h2 class="fw-bold text-dark mb-0 count" data-count="128">0</h2>
                            <div class="d-flex align-items-center justify-content-start gap-2">
                                <span class="badge bg-label-success fs-8 fw-medium">+8%</span>
                                <span class="text-dark fs-8 fw-medium">Vs</span>
                                <span class="text-dark fs-8 fw-medium">Last Month</span>
                            </div>
                        </div>
                        <div class="rounded p-2" style="background-color: #eeeeee;">
                            <i class="mdi mdi-wrench-outline text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
                <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                    <div class="d-flex justify-content-start align-items-start flex-column">
                        <span class="fw-medium fs-7 text-dark">
                            Completed SRV
                        </span>
                        <h2 class="fw-bold text-dark mb-0 count" data-count="96">0</h2>
                        <div class="d-flex align-items-center justify-content-start gap-2">
                            <span class="badge bg-label-success fs-8 fw-medium">+12%</span>
                            <span class="text-dark fs-8 fw-medium">Vs</span>
                            <span class="text-dark fs-8 fw-medium">Last Month</span>
                        </div>
                    </div>
                    <div class="rounded p-2" style="background-color: #eeeeee;">
                        <i class="mdi mdi-check-circle-outline text-primary fs-4"></i>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
                <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="d-flex justify-content-start align-items-start flex-column">
                            <span class="fw-medium fs-7 text-dark">
                                Overdue Valves
                            </span>
                            <h2 class="fw-bold text-dark mb-0 count" data-count="07">0</h2>
                            <div class="d-flex align-items-center justify-content-start gap-2">
                                <span class="badge bg-label-danger fs-8 fw-medium">-3%</span>
                                <span class="text-dark fs-8 fw-medium">Vs</span>
                                <span class="text-dark fs-8 fw-medium">Last Month</span>
                            </div>
                        </div>
                        <div class="rounded p-2" style="background-color: #eeeeee;">
                            <i class="mdi mdi-valve text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
                <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                    <div class="d-flex justify-content-start align-items-start flex-column">
                        <span class="fw-medium fs-7 text-dark">
                            SLA Compilances
                        </span>
                        <h2 class="fw-bold text-dark mb-0 count" data-count="92">0%</h2>
                        <div class="d-flex align-items-center justify-content-start gap-2">
                            <span class="badge bg-label-success fs-8 fw-medium">+4%</span>
                            <span class="text-dark fs-8 fw-medium">Vs</span>
                            <span class="text-dark fs-8 fw-medium">Last Month</span>
                        </div>
                    </div>
                    <div class="rounded p-2" style="background-color: #eeeeee;">
                        <i class="mdi mdi-clock-outline text-primary fs-4"></i>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
        <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
            <label class="fw-medium text-black fs-5">Total Vs Completed SRV's (Monthly-2026)</label>
            <div id="srv_chart"></div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
        <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
            <label class="fw-medium text-black fs-5">Critical Overdue Valves</label>
            <div class="table-wrapper mt-2"  style="max-height:350px; overflow-y:auto;">
                <table class="table align-middle table-row-dashed table-hover gy-0 gs-1 asset_list">
                    <thead class="sticky-top">
                        <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                            <th class="min-w-100px text-black">Asset</th>
                            <th class="min-w-100px text-black">Valve Type</th>
                            <th class="min-w-100px text-black">Overdue By</th>
                        </tr>
                    </thead>
                    <tbody class="text-black fw-semibold fs-7">
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">11-SRV-1</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">12 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">12-SRV-4019-101</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">5 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">14-SRV-5232-01</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">9 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">11-SRV-3</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">18 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">21-SRV-102</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">7 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">18-SRV-889</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">22 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">15-SRV-220</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">14 Days</label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="text-black fw-medium fs-7">10-SRV-78</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">Safety Relief Valve</label>
                            </td>
                            <td>
                                <label class="text-black fw-medium fs-7">3 Days</label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
        <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
            <label class="fw-medium text-black fs-5">Resource Utilization (Weekly in Mar-2026)</label>
            <div id="utilization_chart"></div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
        <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
            <label class="fw-medium text-black fs-5">Overdue of Valves by Types</label>
            <div id="overdue_valve_chart"></div>
        </div>
    </div>
</div>

<script>
    var options = {
    series: [
        {
        name: 'Total SRV',
        data: [42, 38, 45, 50, 47, 55, 60, 58, 63, 66, 70, 74]
        },
        {
        name: 'Completed SRV',
        data: [35, 32, 40, 44, 41, 48, 53, 50, 57, 60, 63, 69]
        }
    ],
    chart: {
        type: 'bar',
        height: 344
    },
    plotOptions: {
        bar: {
        horizontal: false,
        columnWidth: '65%',
        borderRadius: 5,
        borderRadiusApplication: 'end'
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: [
        'Jan','Feb','Mar','Apr','May','Jun',
        'Jul','Aug','Sep','Oct','Nov','Dec'
        ]
    },
    yaxis: {
        title: {
        text: 'Number of SRVs'
        }
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
        formatter: function (val) {
            return val + " SRVs";
        }
        }
    }
    };

    var chart = new ApexCharts(document.querySelector("#srv_chart"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
            name: 'Resources',
            data: [31, 40, 28, 51, 42, 65, 58]
        }, {
            name: 'Equipment',
            data: [21, 32, 35, 42, 38, 48, 41]
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
            show: false
            }
        },
        colors: ['#f5a91c', '#a320f0'], // Blue & Green

        dataLabels: {
            enabled: false
        },

        stroke: {
            curve: 'smooth',
            width: 3
        },

        fill: {
            type: 'gradient',
            gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.5,
            opacityTo: 0.1,
            stops: [0, 90, 100]
            }
        },

        xaxis: {
            categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']
        },

        yaxis: {
            title: {
            text: 'Utilization (%)'
            },
            max: 100
        },

        tooltip: {
            y: {
            formatter: function (val) {
                return val + "%";
            }
            }
        },

        legend: {
            position: 'top'
        }
    };

    var chart = new ApexCharts(document.querySelector("#utilization_chart"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [12, 8, 6, 10, 5], // Overdue counts
        chart: {
            type: 'donut',
            height: 398
        },

        labels: [
            'SRV Valves',
            'Gate Valves',
            'Globe Valves',
            'Ball Valves',
            'Check Valves'
        ],

        colors: [
            '#ef4444',  // SRV - Red (critical)
            '#3b82f6',  // Gate - Blue
            '#f59e0b',  // Globe - Orange
            '#10b981',  // Ball - Green
            '#8b5cf6'   // Check - Purple
        ],

        dataLabels: {
            enabled: true
        },

        legend: {
            position: 'bottom'
        },

        plotOptions: {
            pie: {
            donut: {
                size: '65%'
            }
            }
        },

        tooltip: {
            y: {
            formatter: function(val) {
                return val + " Overdue Valves";
            }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#overdue_valve_chart"), options);
    chart.render();
</script>

<script>
    function animateCounts() {
        const counters = document.querySelectorAll('.count');
        counters.forEach(counter => {
            const isPercent = counter.innerText.includes('%'); // detect %
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                let current = +counter.innerText.replace('%',''); // remove % for calculation
                const increment = Math.ceil(target / 100); // adjust speed here
                if(current < target) {
                    current += increment;
                    if(current > target) current = target; // cap to target
                    counter.innerText = isPercent ? current + '%' : current;
                    setTimeout(updateCount, 20); // animation speed
                } else {
                    counter.innerText = isPercent ? target + '%' : target;
                }
            }
            updateCount();
        });
    }

    window.addEventListener('DOMContentLoaded', animateCounts);
</script>
@endsection