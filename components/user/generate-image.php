<?php 
  //* Check if graph has already has a report
  $report_graph_sql = $connect->prepare("SELECT * FROM reports WHERE id_graph = ?");
  $report_graph_sql->execute([$graph['id_graph']]);
  
  if(!($report_graph = $report_graph_sql->fetch(PDO::FETCH_ASSOC))){
    ?>
    <script>
        //* Generate image if report not found

        // Wait for the graph to fully load
        chart.options.animation.onComplete = function() {
          setTimeout(function() {
            // Get the canvas element
            const canvasP = document.getElementById("prediction-chart");
            const canvasTS = document.getElementById("time-chart");

            // Get the image data URL
            const imageDataURLP = canvasP.toDataURL("image/png");
            const imageDataURLTS = canvasTS.toDataURL("image/png");

            // Create a new XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            // Set the request method and URL
            xhr.open("POST", "../backend/report.php", true);

            // Set the request headers
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Send the image data to the server
            xhr.send("image_data_prediction=" + encodeURIComponent(imageDataURLP) + "&image_data_ts=" + encodeURIComponent(imageDataURLTS) + "&id_graph=" + <?php echo $graph['id_graph']?>);

            // Handle the response from the server
            xhr.onload = function() {
              if (xhr.status === 200) {
                console.log("Graph image saved successfully!");
              } else {
                console.error("Error saving graph image:", xhr.statusText);
              }
            };
          }, 1000); // Wait for 1 second
        };
      </script>

    <?php
  }
?>