<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:text-slate-100 p-4 md:p-6">
  <div class="flex justify-between mb-10">
    <div>
      <!-- <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">Water Level</h5> -->
      <!-- <p class="text-base font-normal text-gray-500 dark:text-gray-400">Time Series Graph</p> -->
    </div>
  </div>
  <div id="time-series-chart"></div>
</div>
<?php
  $file_name_graph = $graph['file_name_graph'];
  $filename = "../uploads/documents/$file_name_graph";
  $handle = fopen($filename, "r");
?>


<script>
const TimeSeriesData = {
// add data series via arrays, learn more here: https://apexcharts.com/docs/series/
// add data series via arrays, learn more here: https://apexcharts.com/docs/series/
series: [{
    name: "<?php echo htmlspecialchars($graph['val_one_name_graph'])?>",
    data: [
      <?php 
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
          echo $data['2'] . ', ';
        }
      ?>
    ],
    color: "#1A56DB",
  },],
chart: {
  height: "100%",
  maxWidth: "100%",
  type: "area",
  fontFamily: "Inter, sans-serif",
  dropShadow: {
    enabled: false,
  },
  
},
title: {
  text: 'Time Series Graph',
  align: 'left'
},
subtitle: {
  text: '<?php echo htmlspecialchars(ucfirst(strtolower($graph['val_one_name_graph'])))?> / <?php echo htmlspecialchars(ucfirst(strtolower($graph['val_two_name_graph'])))?>',
  align: 'left'
},
tooltip: {
  enabled: true,
  x: {
    show: false,
  },
},
legend: {
  show: false
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
  show: false,
  strokeDashArray: 4,
  padding: {
    left: 2,
    right: 2,
    top: 0
  },
},
xaxis: {
  categories: [
  ],
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
      return value + '<?php echo htmlspecialchars(strtolower($graph['val_one_unit_graph']))?>';
    }
  }
},
}

if (document.getElementById("time-series-chart") && typeof ApexCharts !== 'undefined') {
const chart = new ApexCharts(document.getElementById("time-series-chart"), TimeSeriesData);
chart.render();
}
</script>

