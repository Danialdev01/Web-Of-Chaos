
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:text-slate-100 p-4 md:p-6">
  <div class="flex justify-between mb-10">
    <div>
      <!-- <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">Water Level</h5> -->
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">Time Series Graph</p>
    </div>
    <!-- <div
      class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
      94% CC
      <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
      </svg>
    </div> -->
  </div>
  <div id="test-time-series-chart"></div>
</div>
  <?php 
    $filename = "../uploads/documents/66a1b8ec8cdd5.txt";
    $data = file_get_contents($filename);
    echo $data;
  ?>


<script>
const TestTimeSeriesData = {
series: [
  {
    name: "Time Series",
    data: [21, 24, 25, 26, 22, 23, 25, 24, 24, 25, 23, 24, 25, 25, 26, 25, 26, 25, 25, 24, 23, 22, 23, 23, 24, 23, 25, 24],
    color: "#1A56DB",
  },
],
chart: {
  height: "100%",
  maxWidth: "100%",
  type: "area",
  fontFamily: "Inter, sans-serif",
  dropShadow: {
    enabled: false,
  },
  toolbar: {
    show: false,
  },
},
tooltip: {
  enabled: true,
  x: {
    show: false,
  },
},
legend: {
  show: true
},
fill: {
  type: "gradient",
  gradient: {
    opacityFrom: 0.55,
    opacityTo: 0,
    shade: "#1C64F2",
    gradientToColors: ["#1C64F2"],
  },
},
dataLabels: {
  enabled: false,
},
stroke: {
  width: 6,
},
grid: {
  show: true,
  strokeDashArray: 4,
  padding: {
    left: 2,
    right: 2,
    top: -26
  },
},
xaxis: {
  // categories: ['0', '50', '100', '150', '200', '250', '300'],
  labels: {
    show: false,
  },
  axisBorder: {
    show: false,
  },
  axisTicks: {
    show: false,
  },
},
yaxis: {
  show: true,
  labels: {
    formatter: function (value) {
      return value + "m";
    }
  }
},
}

if (document.getElementById("test-time-series-chart") && typeof ApexCharts !== 'undefined') {
const chart = new ApexCharts(document.getElementById("test-time-series-chart"), TestTimeSeriesData);
chart.render();
}
</script>
