<div style="width: 100%;">
<div class="mo_wpns_divided_layout">
<div class="mo_wpns_setting_layout">
    <script type="text/javascript">
      function mosa_drawVisualization() {
        var result = <?php echo json_encode($result, true); ?>;
        var data12 = google.visualization.arrayToDataTable([
            ['visited_page', 'visited_page_count']
            <?php
                echo ",";
                $length_visited_page = count($result);
                for ($i = 0; $i < $length_visited_page; $i++)
                {
                    echo "[result[$i].visited_page,parseInt(result[$i].visited_page_count)],";
                }
            ?>   
        ]);
         var options = {
         title: 'Top Pages visited',
         pieHole: 0.4,
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data12, options);
      }
      google.setOnLoadCallback(mosa_drawVisualization);
    </script>
    <div id="donutchart" style="width: 800px !important; height: 500px;"></div>
    <script type="text/javascript">
    google.setOnLoadCallback(mosa_draw_browser_Chart);
    function mosa_draw_browser_Chart() {
     
      var browser_chart = <?php echo json_encode($browser_chart, true); ?>;
        var datab = google.visualization.arrayToDataTable([
             
            ["browser", "Total Clicks"]
            <?php
            echo ",";
            $length = count($browser_chart);
            for ($i = 0; $i < $length; $i++) {
                    echo "[browser_chart[$i].browser,parseInt(browser_chart[$i].data)],";
                   
                }
          ?>
        ]);
      var viewb = new google.visualization.DataView(datab);
      viewb.setColumns([0, 1]);

      var options = {
        title: "Browser Used",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(viewb, options);
  }
</script>
  <div id="columnchart_values" style="width: 900px !important; height: 300px; margin-top: 1%;"></div>
<br>

    <script type="text/javascript">
      function mosa_drawplatform() {
      var platform_chart = <?php echo json_encode($platform_chart, true); ?>;
        var data_platform_chart = google.visualization.arrayToDataTable([
            ["platform", "count"]
         <?php
            echo ",";
            $length = count($platform_chart);
            for ($i = 0; $i < $length; $i++) {

                    echo "[platform_chart[$i].platform,parseInt(platform_chart[$i].data)],";
                   
                }
           ?>
        ]);
        var view = new google.visualization.DataView(data_platform_chart);
      view.setColumns([0, 1]);
        var options = {
        title: "Platform Used",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_platform_chart"));
      chart.draw(view, options);
      }
      google.setOnLoadCallback(mosa_drawplatform);
    </script>
    <div id="columnchart_values_platform_chart" style="width: 500px; height: 400px;"></div>
<script>
    google.setOnLoadCallback(mosa_draw_device_chart);
        function mosa_draw_device_chart() {
            var device_chart = <?php echo json_encode($device_chart, true); ?>;
            var data_device_chart = google.visualization.arrayToDataTable([ ["device", "count"]
            <?php
                echo ",";
                $length = count($device_chart);
                for ($i = 0; $i < $length; $i++) {
                    echo "[device_chart[$i].device,parseInt(device_chart[$i].data)],";
                }
            ?>
            ]);
      var view = new google.visualization.DataView(data_device_chart);
      view.setColumns([0, 1]);
      var options = {
        title: "Device Used",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values_device_chart"));
      chart.draw(view, options);
  }
</script>
</div>
</div>
</div>
 