@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
'resources/assets/vendor/scss/pages/cards-statistics.scss',
'resources/assets/vendor/scss/pages/cards-analytics.scss'
])
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/apex-charts/apexcharts.js',
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
                              Total Work Order
                          </span>
                          <h2 class="fw-bold text-dark mb-0 count" data-count="42">0</h2>
                          <div class="d-flex align-items-center justify-content-start gap-2">
                              <span class="badge bg-label-success fs-8 fw-medium">+8%</span>
                              <span class="text-dark fs-8 fw-medium">Vs</span>
                              <span class="text-dark fs-8 fw-medium">Last Month</span>
                          </div>
                      </div>
                      <div class="rounded p-2" style="background-color: #dbf2ff;">
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
                          Completed On Time
                      </span>
                      <h2 class="fw-bold text-dark mb-0 count" data-count="85">0%</h2>
                      <div class="d-flex align-items-center justify-content-start gap-2">
                          <span class="badge bg-label-success fs-8 fw-medium">+5%</span>
                          <span class="text-dark fs-8 fw-medium">Vs</span>
                          <span class="text-dark fs-8 fw-medium">Last Month</span>
                      </div>
                  </div>
                  <div class="rounded p-2" style="background-color: #defdec;">
                      <i class="mdi mdi-check-circle-outline text-success fs-4"></i>
                  </div>
                  </div>
              </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
              <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                  <div class="d-flex justify-content-between align-items-start mb-1">
                      <div class="d-flex justify-content-start align-items-start flex-column">
                          <span class="fw-medium fs-7 text-dark">
                              Delayed Orders
                          </span>
                          <h2 class="fw-bold text-dark mb-0 count" data-count="6">0</h2>
                          <div class="d-flex align-items-center justify-content-start gap-2">
                              <span class="badge bg-label-danger fs-8 fw-medium">-2%</span>
                              <span class="text-dark fs-8 fw-medium">Vs</span>
                              <span class="text-dark fs-8 fw-medium">Last Month</span>
                          </div>
                      </div>
                      <div class="rounded p-2" style="background-color: #fff8dd;">
                          <i class="mdi mdi-clock-outline text-warning fs-4"></i>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 mb-2">
              <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
                  <div class="d-flex justify-content-between align-items-start mb-1">
                  <div class="d-flex justify-content-start align-items-start flex-column">
                      <span class="fw-medium fs-7 text-dark">
                          Critical Alerts
                      </span>
                      <h2 class="fw-bold text-dark mb-0 count" data-count="3">0</h2>
                      <div class="d-flex align-items-center justify-content-start gap-2">
                          <span class="badge bg-label-danger fs-8 fw-medium">-50%</span>
                          <span class="text-dark fs-8 fw-medium">Vs</span>
                          <span class="text-dark fs-8 fw-medium">Last Month</span>
                      </div>
                  </div>
                  <div class="rounded p-2" style="background-color: #ffe1e0;">
                      <i class="mdi mdi-alert-circle-outline text-danger fs-4"></i>
                  </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
    <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
      <div class="d-flex align-items-center justify-content-between gap-5">
        <label class="fw-medium text-black fs-5">Compilance Health</label>
        <div class="d-flex align-items-center flex-column">
          <label class="fw-medium text-dark fs-5">Overall Score</label>
          <label class="fw-medium text-primary fs-2" id="overall-score">0%</label>
        </div>
      </div>
      <div id="compilance_health_chart"></div>
    </div>
  </div>
  <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4">
    <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
      <label class="fw-medium text-black fs-5">Delay Analysis (past 6 Months)</label>
      <div id="delay_chart"></div>
      <div class="d-flex align-items-center justify-content-around gap-5">
        <div class="d-flex align-items-center flex-column">
          <label class="fw-medium text-dark fs-5">Avg. Delay Days</label>
          <label class="fw-medium text-primary fs-2" id="avg_delay"></label>
        </div>
        <div class="d-flex align-items-center flex-column">
          <label class="fw-medium text-dark fs-5">On Time Rate</label>
          <label class="fw-medium text-primary fs-2" id="on_time_rate">%</label>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="card px-3 py-3 bg-white rounded border" style="box-shadow: none;">
      <div class="row">
        <div class="col-lg-12 mb-2">
          <label class="fw-medium text-black fs-5">Work Orders</label>
        </div>
        <div class="col-lg-12 table-wrapper mt-2" style="max-height:500px; overflow-y:auto;">
          <table class="table align-middle table-row-dashed table-striped table-hover gy-0 gs-1 ">
              <thead>
                  <tr class="text-center align-top fw-bold fs-6 gs-0 bg-gray-200">
                    <th class="min-w-100px text-black">Order/Type</th>
                    <th class="min-w-100px text-black">Priority</th>
                    <th class="min-w-100px text-black">Work Ctr/Plant</th>
                    <th class="min-w-100px text-black">Description</th>
                    <th class="min-w-100px text-black">Team</th>
                    <th class="min-w-100px text-black">Status</th>
                  </tr>
              </thead>
              <tbody class="text-black fw-semibold fs-7">
                <tr>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">13811979</label>
                            <label class="text-info fw-medium fs-8">PREV</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7">C - C-Med Potential Loss</label>
                    </td>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">METC</label>
                            <label class="text-dark fw-medium fs-8">KUFA</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7 text-truncate max-w-150px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="SRV,VOL TANK 62-V-0009B,62-SRV-0009B,MEC
                            VALVE,RELIEF,REMOVE,5Y
                            VALVE,RELIEF,OVERHAUL,5Y
                            VALVE,RELIEF,TEST,5Y">
                            SRV,VOL TANK 62-V-0009B,62-SRV-0009B,MEC
                            VALVE,RELIEF,REMOVE,5Y
                            VALVE,RELIEF,OVERHAUL,5Y
                            VALVE,RELIEF,TEST,5Y
                        </label>
                    </td>
                    <td>
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Sarah Connor" data-bs-original-title="Sarah Connor">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_2.png') }}" alt="Avatar">
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Mohammed Fazil" data-bs-original-title="Mohammed Fazil">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_3.png') }}" alt="Avatar">
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Andrew" data-bs-original-title="Andrew">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_1.png') }}" alt="Avatar">
                            </li>
                            <li class="avatar">
                                <span class="avatar-initial rounded-circle bg-primary pull-up text-white" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="3 more">+3</span>
                            </li>
                        </ul>
                    </td>
                    <td>
                        <label class="fw-medium fs-7 badge rounded" style="border: 1px solid #4a154b;color: #4a154b;background-color: #4a154b12;">Preparation</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">13811980</label>
                            <label class="text-info fw-medium fs-8">PREV</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7">A - High Pressure Valve Maintenance</label>
                    </td>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">QGPC</label>
                            <label class="text-dark fw-medium fs-8">RAS LAFAN</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7 text-truncate max-w-150px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="SRV,HP GAS LINE 22-V-1011A,22-SRV-1011A
                            VALVE,RELIEF,REMOVE,5Y
                            VALVE,RELIEF,OVERHAUL,5Y
                            VALVE,RELIEF,TEST,5Y">
                            SRV,HP GAS LINE 22-V-1011A,22-SRV-1011A
                            VALVE,RELIEF,REMOVE,5Y
                            VALVE,RELIEF,OVERHAUL,5Y
                            VALVE,RELIEF,TEST,5Y
                        </label>
                    </td>
                    <td>
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_2.png') }}" alt="Avatar">
                            </li>
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_3.png') }}" alt="Avatar">
                            </li>
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_1.png') }}" alt="Avatar">
                            </li>
                        </ul>
                    </td>
                    <td>
                        <label class="fw-medium fs-7 badge rounded"
                            style="border: 1px solid #f59e0b; color: #f59e0b; background-color: #f59e0b1a;">
                            Draft
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">13811981</label>
                            <label class="text-info fw-medium fs-8">PREV</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7">B - Pressure Relief Valve Overhaul</label>
                    </td>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">QP</label>
                            <label class="text-dark fw-medium fs-8">MESAIEED</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7 text-truncate max-w-150px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="SRV,CONDENSATE TANK 33-V-2050B,33-SRV-2050B
                            VALVE,RELIEF,REMOVE
                            VALVE,RELIEF,OVERHAUL
                            VALVE,RELIEF,CALIBRATE">
                            SRV,CONDENSATE TANK 33-V-2050B,33-SRV-2050B
                            VALVE,RELIEF,REMOVE
                            VALVE,RELIEF,OVERHAUL
                            VALVE,RELIEF,CALIBRATE
                        </label>
                    </td>
                    <td>
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_3.png') }}" alt="Avatar">
                            </li>
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_1.png') }}" alt="Avatar">
                            </li>
                        </ul>
                    </td>
                    <td>
                        <label class="fw-medium fs-7 badge rounded" style="border: 1px solid #0d6efd;color: #0d6efd;background-color: #0d6efd12;">Execution</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">13811982</label>
                            <label class="text-info fw-medium fs-8">PREV</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7">D - Safety Valve Inspection</label>
                    </td>
                    <td>
                        <div class="d-flex align-items-start flex-column">
                            <label class="text-black fw-medium fs-7">NAKILAT</label>
                            <label class="text-dark fw-medium fs-8">DOHA PORT</label>
                        </div>
                    </td>
                    <td>
                        <label class="text-black fw-medium fs-7 text-truncate max-w-150px" data-bs-toggle="tooltip" data-bs-placement="bottom" title="SRV,LPG STORAGE 51-V-3322A,51-SRV-3322A
                            VALVE,RELIEF,TEST
                            VALVE,RELIEF,INSPECTION">
                            SRV,LPG STORAGE 51-V-3322A,51-SRV-3322A
                            VALVE,RELIEF,TEST
                            VALVE,RELIEF,INSPECTION
                        </label>
                    </td>
                    <td>
                        <ul class="list-unstyled users-list d-flex align-items-center avatar-group">
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_1.png') }}" alt="Avatar">
                            </li>
                            <li class="avatar pull-up">
                                <img class="rounded-circle" src="{{ asset('assets/images/auth/user_2.png') }}" alt="Avatar">
                            </li>
                        </ul>
                    </td>
                    <td>
                        <label class="fw-medium fs-7 badge rounded" style="border: 1px solid #198754;color: #198754;background-color: #19875412;">Completed</label>
                    </td>
                </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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

<script>
  var data = [70, 20, 10]; 
  var labels = ['Fully Compliant', 'Minor Issues', 'Needs Attention'];
  var colors = ['#0c78b6', '#df609b', '#727e05'];

  function calculateOverallScore(series) {
      var weights = [1, 0.5, 0]; 
      var total = 0;
      var sumSeries = 0;

      for (var i = 0; i < series.length; i++) {
          total += series[i] * weights[i];
          sumSeries += series[i];
      }
      return Math.round(total / sumSeries); 
  }

  var overallScore = calculateOverallScore(data);
  document.getElementById('overall-score').innerText = overallScore + "%";

  var options = {
      series: data,
      chart: {
          height: 426,
          type: 'pie',
          animations: {
              enabled: true,
              easing: 'easeinout',
              speed: 1200
          }
      },
      labels: labels,
      colors: colors,
      responsive: [{
          breakpoint: 480,
          options: {
              chart: { width: 250 },
              legend: { position: 'bottom' }
          }
      }],
      dataLabels: {
          enabled: true,
          formatter: function (val, opts) {
              return opts.w.globals.labels[opts.seriesIndex] + ": " + val.toFixed(0) + "%";
          }
      },
      legend: {
          position: 'bottom',
          offsetY: 0
      },
      tooltip: {
          y: { formatter: function (val) { return val + "%"; } }
      }
  };

  var chart = new ApexCharts(document.querySelector("#compilance_health_chart"), options);
  chart.render();
</script>

<script>

  var delayDays = [4, 6, 3, 8, 2, 5];
  var completedJobs = [40, 38, 45, 42, 48, 50];
  var onTimeJobs = [34, 30, 40, 33, 45, 44];

  function getLastSixMonths() {
    const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    let currentMonth = new Date().getMonth(); 
    let result = [];

    for (let i = 6; i >= 1; i--) {
        let index = (currentMonth - i + 12) % 12;
        result.push(months[index]);
    }

    return result;
  }

  var months = getLastSixMonths();

  var totalDelay = delayDays.reduce((a,b)=>a+b,0);
  var avgDelay = (totalDelay / delayDays.length).toFixed(1);
  var totalCompleted = completedJobs.reduce((a,b)=>a+b,0);
  var totalOnTime = onTimeJobs.reduce((a,b)=>a+b,0);
  var onTimeRate = ((totalOnTime / totalCompleted) * 100).toFixed(1);

  document.getElementById("avg_delay").innerText = avgDelay + "days";
  document.getElementById("on_time_rate").innerText = onTimeRate + "%";

  var options = {
    series: [
    {
      name: 'Delay Days',
      data: delayDays
    },
    {
      name: 'Completed Jobs',
      data: completedJobs
    },
    {
      name: 'On-Time Jobs',
      data: onTimeJobs
    }
    ],
    chart: {
      type: 'bar',
      height: 350,
      toolbar:{
        show:false
      },
      animations:{
        enabled:true,
        easing:'easeinout',
        speed:1200
      }
    },

    colors: [
      '#ef4486',   // Delay - red
      '#67f63b',   // Completed - blue
      '#4b10b9'    // On-time - green
    ],

    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '50%',
        borderRadius: 6,
        borderRadiusApplication: 'end'
      }
    },

    fill: {
      type: "gradient",
      gradient: {
        // shade: 'light',
        type: "vertical",
        shadeIntensity: 0.3,
        opacityFrom: 0.9,
        opacityTo: 0.6,
        stops: [0,100]
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
      categories: months,
      title: {
        text: 'Last 6 Months'
      }
    },

    yaxis: {
      title: {
        text: 'Days / Job Count'
      }
    },

    grid:{
      borderColor:'#e7e7e7',
      strokeDashArray:4
    },

    tooltip: {
      y: {
        formatter: function (val, opts) {
          if(opts.seriesIndex === 0){
              return val + " Days Delay";
          }
          return val + " Jobs";
        }
      }
    },

    legend:{
      position:'top',
      horizontalAlign:'right'
    }

  };

  var chart = new ApexCharts(document.querySelector("#delay_chart"), options);
  chart.render();

</script>
@endsection