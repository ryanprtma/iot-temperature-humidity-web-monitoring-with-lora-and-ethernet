<?php
session_start();
include "config/koneksi.php";
include "config/function.php";
date_default_timezone_set('Asia/Jakarta');
$Tanggal = date("Y-m-d");
$suhu = mysqli_query($koneksi, "SELECT suhu FROM datasensor ORDER BY id DESC LIMIT 5");
$waktu = mysqli_query($koneksi, "SELECT waktu FROM datasensor ORDER BY id DESC LIMIT 5");
  ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stasiun Cuaca</title>
    <link rel="stylesheet" href="../atur.css">
    <script src="config/Chart.js"></script>
    <style type="text/css">
            .grafik {
                width: 50%;
                margin: 15px auto;
            }
    </style>
</head>
<body>

<div class="">
    <div class="grafik">
        <center>
          <h2>Grafik Hasil Pengukuran Suhu</h2>
          <div style="width: 80%; height: 250px;">
              <canvas id="linechart"></canvas>
              
          </div>
        </center>
    </div>
</div>

<script  type="text/javascript">
    var ctx = document.getElementById("linechart").getContext("2d");
    var data = {
        labels: [<?php while($p = mysqli_fetch_array($waktu)){echo '"'. $p['waktu']. '",';} ?>],
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
                data: [<?php while($p = mysqli_fetch_array($suhu)){echo '"'. $p['suhu'].'",';} ?>]
                }
            ]
        };

    var myBarChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
        legend: {
        display: true
        },
        barValueSpacing: 20,
        scales: {
        yAxes: [{
        ticks: {
            min: 0,
            }
            }],
        xAxes: [{
            gridLines: {
            color: "rgba(105, 0, 132, .2)",
            }
        }]
    }
    }
    });
</script>
</body>
</html>