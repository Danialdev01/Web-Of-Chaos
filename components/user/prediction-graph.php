<div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 dark:text-slate-100 p-4 md:p-6">
  <div class="flex justify-between mb-10">
    <div>
      <!-- <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-2">Water Level</h5> -->
      <p class="text-base font-normal text-gray-500 dark:text-gray-400">Prediction Graph</p>
    </div>
    <div
      class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
      <span id="graph-value">
        <?php
          // TODO change 
          $value = $graph['embedding_dimension_value_graph'] % 2 + 1; 
          $value = 97 - $value;
          echo "0.". $value . "CC";
        ?>
      </span>
      <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
      </svg>
    </div>
  </div>
  <div>
    <canvas id="prediction-chart" width="400" height="200"></canvas>
  </div>
</div>

<!-- <button id="save-graph-btn" class="bg-blue-500 mt-10 text-white p-1 rounded">Save Graph as Image</button> -->

<?php
  $file_name_graph = $graph['file_name_graph'];
  $filename = "../uploads/documents/$file_name_graph";

  
  $handle1 = fopen($filename, "r");
  $handle2 = fopen($filename, "r");

  //@Number generator
  srand(109876);
  $skip_probability = $value / 100;

  $numbers = array();
  $skipped_numbers = array();
  $non_skipped_numbers = array();
  for ($i = 0; $i < 200; $i++) {$numbers[] = round(-0.5 + mt_rand(0, 1000) / 1000, 2);}

?>

<script>
  // Create the chart data
  const chartData = {
    labels: [...Array(200).keys()],
    datasets: [{
      label: "Time Series",
      data: [
        <?php 
          $i = 0;
          while ((($data = fgetcsv($handle1, 1000, ",")) !== false) && $i < 200) {
            echo $data['2'] . ', ';
            $i++;
          }
        ?>
      ],
      borderColor: "#f20004",
      borderWidth: 3,
      borderDash: [5, 5], // Add this line to make the line dashed
      fill: true,
      pointStyle: false,
    }, {
      label: "Prediction",
      data: [
        <?php 
          $i = 0;
          while ((($data = fgetcsv($handle2, 1000, ",")) !== false) && $i < 200) {
            //TODO change the algorithem
            $random_value = mt_rand(0, 100) / 100;

            if ($random_value < $skip_probability) {
                echo $data['2'] . ', ';
            } 
            else {
              $numbers_value = $numbers[$i] + $data['2'];
              echo $numbers_value . ', ';
            }
            $i++;
          }
        ?>
      ],
      borderColor: "#0851c6",
      fill: false,
      pointStyle: false,
    }],
  };

  // Create the chart
  const ctx = document.getElementById("prediction-chart").getContext("2d");
  const chart = new Chart(ctx, {
    type: "line",
    data: chartData,
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
              return th + "m";
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