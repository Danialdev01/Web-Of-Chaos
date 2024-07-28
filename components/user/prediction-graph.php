
<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:text-slate-100 p-4 md:p-6">
  <div class="flex justify-between mb-10">
    <div>
      <!-- <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">Water Level</h5> -->
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">Prediction Graph</p>
    </div>
    <div
      class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
      0.94 CC
      <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
      </svg>
    </div>
  </div>
  <div id="prediction-chart"></div>
</div>


<script>
const options = {
// add data series via arrays, learn more here: https://apexcharts.com/docs/series/
series: [
  {
    name: "Time Series",
    data: [24, 23, 25, 26, 24, 23, 24, 26, 26, 25],
    color: "#1A56DB",
  },
  {
    name: "Prediction",
    data: [24, 24, 25, 27, 24, 23, 25, 26, 25, 25],
    color: "#7E3BF2",
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
  categories: ['0', '25', '50', '75', '100', '125', '150', '175', '200', '250', '300'],
  labels: {
    show: true,
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

if (document.getElementById("prediction-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("prediction-chart"), options);
  chart.render();
}
</script>
