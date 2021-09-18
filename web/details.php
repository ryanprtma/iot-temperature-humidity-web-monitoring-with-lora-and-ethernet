<?php
  session_start();

 if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  } 

  include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
?>

<?php
include "grafik/koneksi.php";
?>

<?php
include "headers.php";
?>

<main>
  <div class="kotak">
        <div class="konten">
            
            <div class="datarows" style="justify-content: center; ">
              <center style="
                  display:flex; 
                  color: black; 
                  background-color: #337AB7; 
                  margin-top: 0px; 
                  border-top-right-radius: 12px;
                  border-top-left-radius: 12px;  
                  padding: 20px; 
                  color: white; 
                  font-family: sans-serif; 
                  font-size: 20px;
                  justify-content: center;
              " >
                Grafik Suhu
              </center>
              <div id="Grafik" 
                   style="
                   display: flex;
                   margin-top: px;
                   padding: 20px;
                   width: 100%;
              ">
                 <script src="jquery-latest.js"></script> 
                  <script>
                  var refreshId = setInterval(function()
                  {
                      $('#responsecontainer').load('grafik/data.php');
                  }, 1000);
                  </script>
                        
                  <!-- Begin page content -->
                  <script type="text/javascript" src="grafik/assets/js/jquery-3.4.0.min.js"></script>
                  <script type="text/javascript" src="grafik/assets/js/mdb.min.js"></script>
                      
                  <div id="responsecontainer" style="width: 900px; margin: auto; margin-bottom: 15px;" >
                  </div>
              </div>
            </div>
            <div class="datarows" style="justify-content: center; ">
              <center style="
                  display:flex; 
                  color: black; 
                  background-color: #337AB7; 
                  margin-top: 0px; 
                  border-top-right-radius: 12px;
                  border-top-left-radius: 12px;  
                  padding: 20px; 
                  color: white; 
                  font-family: sans-serif; 
                  font-size: 20px;
                  justify-content: center;
              " >
                Grafik Kelembaban
              </center>
              <div id="Grafik" 
                   style="
                   display: flex;
                   margin-top: px;
                   padding: 20px;
                   width: 100%;
              ">
              <?php 
              date_default_timezone_set('Asia/Jakarta');
              $waktu = mysqli_query($koneksi, "SELECT waktu FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY id ASC");
              // $Tanggal = date("Y-m-d");
              $kelembaban = mysqli_query($koneksi, "SELECT kelembaban FROM ( SELECT * FROM datasensor ORDER BY id DESC LIMIT 20) Var1 ORDER BY id ASC");
              
             ?>
              <!-- <div class="">
                  <div class="grafik">
                      <center>
                        <h2>Grafik Hasil Pengukuran Suhu</h2> -->
                        <div style="width: 900px; margin: auto; margin-bottom: 15px;" >
                            <canvas id="linechart"></canvas>
                        </div>
                      <!-- </center>
                  </div>
              </div> -->
              </div>
            </div>
            <div class="datarows" >
              <center style="
                  display:flex; 
                  color: black; 
                  background-color: #337AB7; 
                  margin-top: 0px; 
                  border-top-right-radius: 12px;
                  border-top-left-radius: 12px;  
                  padding: 20px; 
                  color: white; 
                  font-family: sans-serif; 
                  font-size: 20px;
                  justify-content: center;
                  transition: 0.3s;
              " >
                Tabel Suhu dan Kelembaban
              </center>
              <div id="Tabel" 
                   style="
                   display: flex;
                   margin-top: px;
                   padding: 20px;
                   width: 100%;
                   justify-content: center;
              ">
                <div>
                  <table id="wnnntable" style="border-radius: 12px;">
                    <tr>
                      <th colspan="4" 
                          style="
                          text-align: center; 
                          color:white; 
                          background-color: #413C69; 
                          padding:20px ;
                          font-family: sans-serif; 
                          font-style: normal;
                          font-variant: normal;
                          font-size: 20px;
                          border-top-right-radius: 12px;
                          border-top-left-radius: 12px;
                      ">
                      Data Sensor Suhu Dan Kelembaban Jurusan Fisika Universitas Sriwijaya
                      </th>
                    </tr>
                    <tr style="border-radius: 20px;">
                      <th>No</th>
                      <th>Suhu</th>
                      <th>Kelembaban</th>
                      <th>Waktu</th>
                    </tr>

                    <?php
                    $tampil = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE id IN (SELECT MAX(id) FROM datasensor)");
                    $data = mysqli_fetch_array($tampil); 
                     ?>

                    <?php $jumlahdataperhalaman = 20;
                    $jumlahdata = count(query("SELECT * FROM datasensor ORDER BY id DESC"));
                    $jumlahhalaman = ceil($jumlahdata/$jumlahdataperhalaman);
                    $halamanaktif = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
                    $awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;
                    $show = query("SELECT * FROM datasensor ORDER BY id DESC LIMIT $awaldata, $jumlahdataperhalaman");
                    $i=1;
                    foreach($show as $data) :
                     ?>

                    <tr>
                      <td ><?= $i;?></td>
                      <td ><?=$data['suhu'] ?>&deg;C</td>
                      <td><?=$data['kelembaban'] ?>%</td>
                      <td><?=$data['waktu'] ?></td>
                    </tr>
                    
                    <?php $i++; ?>
                    <?php endforeach; ?>
                  </table>
                  <div class="navigator" style="margin-top: 20px; margin-bottom: 0px;">
                      <?php for($i=1; $i <= $jumlahhalaman; $i++) : ?>
                      <?php if($i == $halamanaktif) : ?>
                          <a id= "button" href="?hal=<?=$i;?>" style="font-weight: bold;  font-size: 12px; text-decoration: none;"><?=$i;?></a>
                      <?php else : ?>
                          <a href="?hal=<?=$i;?>" style="color: white; font-size: 12px; text-decoration: none;" ><?=$i;?></a>
                      <?php endif; ?>
                      <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="datarows">
              <center style="
                  display:flex; 
                  color: black; 
                  background-color: #337AB7; 
                  margin-top: 0px; 
                  border-top-right-radius: 12px;
                  border-top-left-radius: 12px;  
                  padding: 20px; 
                  color: white; 
                  font-family: sans-serif; 
                  font-size: 20px;
                  justify-content: center;
                  transition: 0.3s;
              " >
                Logger
              </center>
                <?php
                if(isset($_GET['sdate']) || isset($_GET['edate']))
                {
                  
                  $sdate = $_GET['sdate'];
                  $edate = $_GET['edate'];  
                  $sqlAdmin = mysqli_query($konek, "SELECT id,waktu,suhu,kelembaban FROM datasensor WHERE waktu BETWEEN ' $sdate ' AND ' $edate ' ORDER BY ID DESC LIMIT 0,100");
                }
                else
                {
                  $sqlAdmin = mysqli_query($konek, "SELECT id,waktu,suhu,kelembaban FROM datasensor ORDER BY ID DESC LIMIT 0,20");
                }
                ?>
              <form class="form-horizontal" method="GET" style="
                  display:flex; 
                  flex-direction: column;
                  color: black; 
                  /*background-color: salmon;*/
                  margin-top: 0px; 
                  padding: 20px; 
                  color: white; 
                  font-family: sans-serif; 
                  font-size: 20px;
                  transition: 0.3s;
              " >
                
                <div class="form-group" style="display: flex; flex-direction: row; /*background-color: lime;*/ flex-basis: 50%; margin-bottom: 5px;">
                
                  <div style="display: flex; color: black; flex-basis: 38.5%; margin-left: 95px; font-family: sans-serif; font-size: 15px;">
                    <strong>Dari tanggal</strong>
                  </div>
                  <div style="display: flex; background-color: white; flex-basis: 61.5%;">
                    <input type="date" name="sdate" class="form-control" value="<?php echo $sdate; ?>" required>
                  </div>
                </div>
                <div class="form-group" style="display: flex; flex-direction: row; /*background-color: lime*/; flex-basis: 50%; margin-bottom: 5px;"> 
                
                  <div style="display: flex; color: black; flex-basis: 38.5%; margin-left: 95px; font-family: sans-serif; font-size: 15px; ">
                    <strong>sampai tanggal</strong>
                  </div>
                  <div style="display: flex; background-color: white; flex-basis: 61.5%;">
                    <input type="date" name="edate" class="form-control" value="<?php echo $edate; ?>" required>
                  </div>
                </div>
                <div class="form-group" style="display: flex; flex-direction: row; /*background-color: lime;*/ flex-basis: 50%"> 
                
                  <div style="display: flex; /*background-color: black;*/ flex-basis: 38.5%; margin-left: 95px;">
                    
                  </div>
                  <div style="display: flex; /*background-color: white;*/ flex-basis: 61.5%;">
                    <input type="submit" class="btn btn-primary" value="Filter" 
                    style="
                      background-color: #337AB7;
                      border: none;
                      color: white;
                      padding:8px 16px;
                      text-decoration: none;
                      margin: 4px 2px;
                      cursor: pointer;
                      border-radius: 5px;
                      font-size: 15px;
                    ">
                    <a href='details.php'  class='btn btn-warning btn-sm'
                    style="
                      background-color: #F0AD4E;
                      border: none;
                      color: white;
                      padding: 8px 16px;
                      text-decoration: none;
                      margin: 4px 2px;
                      cursor: pointer;
                      border-radius: 5px;
                      font-size: 15px;
                    ">Reset</a>
                  </div>
                </div>
              </form>
              <div id="Logger" 
                   style="
                   display: flex;
                   margin-top: 0 px;
                   padding: 0px 20px 20px 20px;
                   width: 80.5%;
                   color: black;
                   justify-content: center;
                   margin: auto;
              ">
                
                
                  <table id="wnnntable" style="border-radius: 12px;">
                    <th colspan="4" 
                        style="
                        text-align: center; 
                        color:white; 
                        background-color: #413C69; 
                        padding:20px ;
                        font-family: sans-serif; 
                        font-style: normal;
                        font-variant: normal;
                        font-size: 20px;
                        border-top-right-radius: 12px;
                        border-top-left-radius: 12px;
                    ">
                    Data Sensor Suhu Dan Kelembaban Jurusan Fisika Universitas Sriwijaya
                    </th>
                    <tr>
                      <th>No</th>
                      <th>Waktu</th>
                      <th>Suhu</th>
                      <th>Kelembaban</th>
                    </tr>
        
                    <tbody>
                      <?php
                        
                      while($data=mysqli_fetch_array($sqlAdmin))
                      {
                        echo "<tr >
                        <td><center>$data[id]</td>
                        <td><center>$data[waktu]</center></td> 
                        <td><center>$data[suhu]</td>
                        <td><center>$data[kelembaban]</td>              
                        </tr>";
                      }
                      ?>
                    </tbody>
                  </table> 
              </div>
            </div>
        </div>
           
  </div>
</main>

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

<?php
include "footers.php";
?>

