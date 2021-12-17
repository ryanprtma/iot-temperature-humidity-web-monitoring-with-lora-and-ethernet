<?php
  session_start();

 if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  } 

  include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Sundeyy Weather</title>
    <link rel="stylesheet" href="font/OpenSans/OpenSans.css">
    <link rel="stylesheet" href="font/OpenSans/OpenSans-SemiBold.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="font/Rimouski/Rimouski.css">

    <script src="config/Chart.js"></script>
</head>

<body>
<header>
    <div class="jumbotron" id="jumbotron"> 
          LABORATORIUM 
          <img class="logo" id="logoUnsri" src="assets/img/logo2.png">
          <img class="logo" id="logoElin" src="assets/img/logo3.png">
          <img class="logo" id="logoBp" src="assets/img/logo1.png">
          <br>OSEANOGRAFI FISIS 
          <br>DAN SAINS ATMOSFER 
    </div >
    <div class="teks-berjalan">
        <marquee>
          MONITORING SUHU DAN KELEMBABAN LABORATORIUM OSEANOGRAFI FISIS DAN SAINS ATMOSFER JURUSAN FISIKA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS  SRIWIJAYA INDERALAYA
        </marquee>
        <!-- <p>o<div class="logout"><a id="logout" href="logout.php">LOGOUT</a></div></p> -->
    </div> 
    </div> 
    <nav id="navbar">
        <ul>
          <li class="active" id="hover"><a href="index.php">HOME</a></li>
          <li  id="hover"><a href="dataharian.php">DATA HARIAN</a></li>
          <li  id="hover"><a href ="details.php">DETAILS</a></li>
        </ul>
    </nav>
</header>

<main>
  <div class="box">
        <div class="content">
            <div class="singledata">
              <div class="kota">
                <!-- <ul>
                  <li>Inderalaya, Sumatera Selatan</li>
                  <li>Data per</li>
                </ul> -->
                <p>
                  Inderalaya, Sumatera Selatan<br>
                  <span>Per 11.41 AM</span>
                </p>
              </div>
              <div class="temp-humi">
                <?php 
                  $tampil = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE id IN (SELECT MAX(id) FROM datasensor) LIMIT 1");
                  $data = mysqli_fetch_assoc($tampil);
                  $jam=$data['time'];
                  // echo date ("d/F/Y", strtotime($jam));
                  date_default_timezone_set('Asia/Jakarta');
                  $stringDate = date('H:i');
                ?>
                  <div class="suhu">
                    <p>
                    <?=$data['suhu'] ?>°C
                    <br><span class="humi">Humidity : <?=$data['kelembaban'] ?>%</span>  
                    </p><br>
                  </div>
                  <div class="astronaut">
                  <img id="astronaut" src="icons/astronaut/astronautblack6.gif" alt="astronaut" style="width:100px;">
                  </div>
                  <div class="temp-icon">
                    <?php        
                      $ambildata = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE id IN (SELECT MAX(id) FROM datasensor) limit 1");
                      $datas = mysqli_fetch_assoc($ambildata);
                      $tempdata = $datas['suhu'];
                      // $tempdata = 100;
                      date_default_timezone_set('Asia/Jakarta');
                      $waktu = date('H:i');
                      if ($tempdata >= 0 && $tempdata <= 30 && $waktu >='05:30' && $waktu <='17:45' ):?>
                        <img id="temp" src="icons/03dw.png" alt="suhu rendah">
                        <img id="humi" src="icons/50dw.png" alt="">
                      <?php elseif ($tempdata >= 31 && $tempdata <=40 && $waktu>='05:30' && $waktu<='17:45'): ?>
                        <img id="temp" src="icons/02dw.png" alt="suhu normal">
                        <img id="humi" src="icons/50dw.png" alt="">
                      <?php elseif ($tempdata >= 41 && $tempdata <=100 && $waktu>='05:30' && $waktu<='17:45'): ?>
                        <img id="temp" src="icons/01dw.png" alt="suhu tinggi">
                        <img id="humi" src="icons/50dw.png" alt="">
                      <?php elseif ($tempdata >= 0 && $tempdata <=30 ): ?>
                        <img id="temp" src="icons/03nw.png" alt="">
                        <img id="humi" src="icons/50nw.png" alt="">
                      <?php elseif ($tempdata >= 31 && $tempdata <=40 ): ?>
                        <img id="temp" src="icons/02nw.png" alt="">
                        <img id="humi" src="icons/50nw.png" alt="">
                      <?php else: ?>
                        <img id="temp" src="icons/01nw.png" alt="">
                        <img id="humi" src="icons/50nw.png" alt="">
                    <?php endif; ?>
                  </div>
              </div>
            </div> 
            
            <div class="statistik">
              <?php
                date_default_timezone_set('Asia/Jakarta');
                $tgl_hari_ini=date("2021-08-09");
                $show= mysqli_query($koneksi," SELECT*FROM datasensor WHERE tgl_hari_ini='$tgl_hari_ini' ORDER BY suhu DESC LIMIT 1");
                $datas = mysqli_fetch_assoc($show);
              ?>
              <div class="max-min">
                <div class="keterangan">
                    <ul style="list-style-type:none;">
                      <li id="suhuTertinggi"><img src="assets/img/temp.png">&ensp;Suhu Tertinggi &emsp;&emsp;&emsp;&ensp;&nbsp;: <?=$datas['suhu'] ?>°C<hr></li>
                      <li id="suhuTerendah">&emsp;&nbsp;Suhu Terendah &emsp;&emsp;&emsp;&nbsp;: 20°C<hr ></li>
                      <li id="kelembabanTertinggi"><img src="assets/img/humidity.png">&nbsp;Kelembaban Tertinggi &nbsp;: 80%<hr></li>
                      <li id="kelembabanTerendah">&emsp;Kelembaban Terendah : 20%<hr></li>
                      <li id="textDatamax-min"><center>data per</center></li>
                    </ul>
                </div> 
              </div>

              <div class="rataRata-Flex">
                <?php
                  $result= mysqli_query($koneksi, "SELECT AVG(suhu) AS rata_rata_suhu FROM datasensor WHERE tgl_hari_ini='".$tgl_hari_ini."' ");
                  $row_ = mysqli_fetch_assoc($result);
                  $average_suhu = $row_['rata_rata_suhu'];
                  $rata_rata_suhu = number_format($average_suhu);
                  $result_= mysqli_query($koneksi, "SELECT AVG(kelembaban) AS rata_rata_kelembaban FROM datasensor WHERE tgl_hari_ini='".$tgl_hari_ini."' ");
                  $row__ = mysqli_fetch_assoc($result_);
                  $average_kelembaban = $row__['rata_rata_kelembaban'];
                  $rata_rata_kelembaban = number_format($average_kelembaban);
                  ;
                ?>
                <div class="rata_rata" id="suhu">
                  <div class="item1">
                    Rata-rata<br>suhu
                  </div>
                  <div class="item2">
                    <?=$rata_rata_suhu?>°C
                  </div>
                  <div class="item3">data per</div>
                </div>
                <div class="rata_rata" id="kelembaban">
                  <div class="item1">
                    Rata-rata<br>kelembaban
                  </div>
                  <div class="item2">
                    <?=$rata_rata_kelembaban?>%
                  </div>
                  <div class="item3">data per</div>
                </div>
              </div>
            </div>   

            <div class="datarow" id="grafik-suhu">
              <script src="jquery-latest.js"></script> 
              <script>
              var refreshId = setInterval(function()
              {
                  $('#responsecontainer').load('data.php');
              }, 5000);
              </script>  
              <!-- Begin page content -->
              <script type="text/javascript" src="grafik/assets/js/jquery-3.4.0.min.js"></script>
              <script type="text/javascript" src="grafik/assets/js/mdb.min.js"></script>
              <div id="responsecontainer" style="width: 500px; " >
              </div>  
            </div>

            <div class="datarow" id="grafik-kelembaban"> 
            <?php 
              date_default_timezone_set('Asia/Jakarta');
              $waktu = mysqli_query($koneksi, "SELECT waktu FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 5) Var1 ORDER BY id ASC");
              // $Tanggal = date("Y-m-d");
              $kelembaban = mysqli_query($koneksi, "SELECT kelembaban FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 5) Var1 ORDER BY id ASC");
            ?>
              <div style="width: 500px; height: 264.64px;">
                <canvas id="linechart"></canvas>
              </div>
            </div>
    
        </div>
        <aside>
          <div class="list">
            <div id="date">
              <p>
              <?php 
              date_default_timezone_set('Asia/Jakarta');
              echo date('l, d M Y');?>
              </p>
            </div>
            <table id="wntable" cellpadding="20">
              <?php
              $sql = mysqli_query($koneksi, "SELECT * FROM datasensor ORDER BY id DESC LIMIT 6");             
              if(mysqli_num_rows($sql) == 0)
              { 
                echo '<tr><td colspan="14">Data Tidak Ada.</td></tr>'; // jika tidak ada entri di database maka tampilkan 'Data Tidak Ada.'
              }else{ // jika terdapat entri maka tampilkan datanya
                $no = 1; // mewakili data dari nomor 1
                while($row = mysqli_fetch_assoc($sql)){ // fetch query yang sesuai ke dalam array
                  echo '
                  <tr>
                    <td>'.$row['time'].'</td>
                    <td>'.$row['suhu'].'°C</td>
                    <td>'.$row['kelembaban'].'%</td>
                  </tr>
                  ';
                  $no++; // mewakili data kedua dan seterusnya
                }
              }
              ?>
            </table>
          </div>
        </aside>  
  </div>
</main>
<footer> Laboratorium Oseanografi Fisis Dan Sains Atmosfer, Jurusan Fisika &#169; 2021, 
      Fakultas Matematika dan Ilmu Pengetahuan Alam &copy; 2021, Universitas Sriwijaya, Inderalaya<br><span><a style="color: white;" href="logout.php" ><i>logout</i></a></span></footer>

<script  type="text/javascript">
var ctx = document.getElementById("linechart").getContext("2d");
var data = {
    labels: [<?php while($p = mysqli_fetch_array($waktu)){echo '"'. $p['waktu']. '",';} ?>],
    datasets: [
        {
            label: "Kelembaban",
            fill: true,
            lineTension: 0.5,
            backgroundColor: "rgba(0, 137, 132, .2)",
            borderColor: "rgba(0, 10, 130, .7)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(0, 10, 130, .7)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(0, 10, 130, .7)",
            pointHoverBorderColor: "rgba(0, 10, 130, .7)",
            pointHoverBorderWidth: 2,
            pointRadius: 5,
            pointHitRadius: 10,
            data: [<?php while($p = mysqli_fetch_array($kelembaban)){echo '"'. $p['kelembaban'].'",';} ?>]
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
<script src="nav.js"></script>
</body>
</html>


