<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:text-slate-100 p-4 md:p-6">
  <div class="flex justify-between mb-10">
    <div>
      <!-- <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">Water Level</h5> -->
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">Time Series Graph</p>
    </div>
  </div>
  <div>
    <canvas id="time-chart" width="400" height="200"></canvas>
  </div>
</div>

<?php
  $file_name_graph = $graph['file_name_graph'];
  $filename = "../uploads/documents/$file_name_graph";
  
  $handle0 = fopen($filename, "r");
  $handle = fopen($filename, "r");
  $num = 0;
  while (($data = fgetcsv($handle0, 1000, ",")) !== false) {
    $num++;
  }

?>

<script>
  // Create the chart data
  const timeSeries = {
    labels: [
      <?php 
        $i = 0;
        while (($data = fgetcsv($handle1, 1000, ",")) !== false) {
          $data = $data['0'];
          echo '"'. $data . '", ';
          $i++;
        }
      ?>
    ],
    datasets: [{
      label: "Time Series",
      data: [
        <?php 
          $i = 0;
          while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            echo $data['2'] . ', ';
            $i++;
          }
        ?>
      ],
      borderColor: "#05a424",
      fill: false,
      pointStyle: false,
    }],
  };

  // Create the chart
  const ctx2 = document.getElementById("time-chart").getContext("2d");
  const chart2 = new Chart(ctx2, {
    type: "line",
    data: timeSeries,
    options: {
      interaction: {
        intersect: false
      },
      animation: {
        duration: 2000, // introduce canvas lag
      },
      scales: {
        y: {
          beginAtZero: false,
          ticks: {
            callback: function(value) {
              let th = value.toFixed(2);
              return th + "<?php echo $graph['val_one_unit_graph']?>";
            },
          },
        },
      },
      plugins: {
        legend: {
          display: true,
        },
        zoom: {
          limits: {
            y: {min: 0, max: 100},
            y2: {min: -5, max: 5}
          },
        }
      },
    },
  });
</script>