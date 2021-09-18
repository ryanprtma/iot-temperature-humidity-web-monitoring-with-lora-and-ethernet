<?php
include "koneksi.php";
?>

<?php
  $x_tanggal  = mysqli_query($konek, 'SELECT waktu FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
  $y_suhu   = mysqli_query($konek, 'SELECT suhu FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
  $y_kelembaban   = mysqli_query($konek, 'SELECT kelembaban FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY ID ASC');
  ?>

  <div class="panel panel-primary">
    <div class="panel-body">
      <canvas id="myChart"></canvas>
      <script>
       var canvas = document.getElementById('myChart');
        var data = {
            labels: [<?php while ($b = mysqli_fetch_array($x_tanggal)) { echo '"' . $b['waktu'] . '",';}?>],
            datasets: [
            {
                label: "Suhu",
                fill: true,
                lineTension: 0.5,
                backgroundColor: "rgba(105, 0, 132, .2)",
                borderColor: "rgba(200, 99, 132, .7)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(200, 99, 132, .7)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(200, 99, 132, .7)",
                pointHoverBorderColor: "rgba(200, 99, 132, .7)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [<?php while ($b = mysqli_fetch_array($y_suhu)) { echo  $b['suhu'] . ',';}?>],
            }
            ]
        };

        var option = 
        {
          showLines: true,
          animation: {duration: 0}
        };
        
        var myLineChart = Chart.Line(canvas,{
          data:data,
          options:option
        });

      </script>          
    </div>    
  </div>

  
  </div>