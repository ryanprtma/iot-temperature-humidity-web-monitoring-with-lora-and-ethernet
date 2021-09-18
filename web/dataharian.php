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
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>Sundeyy Weather</title>
    <link rel="stylesheet" href="font/OpenSans/OpenSans.css">
    <link rel="stylesheet" href="font/OpenSans/OpenSans-SemiBold.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,600;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="font/Rimouski/Rimouski.css">  

    <!-- Bootstrap core CSS -->
    <!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> -->
    
</head>

<body>
  <header>
      <div class="jumbotron"> 
          <p lang="id" translte=no >LABORATORIUM <img class="mb-4" src="assets//img/logo2.png" width="200" style="float: right;"><img class="mb-4" src="assets/img/logo3.png" width="60" style="float: right; position: relative;"><img class="mb-4" src="assets//img/logo1.png" width="90" style="float: right;"><br>OSEANOGRAFI FISIS <br>DAN SAINS ATMOSFER </p>
      </div >
      <div class="teks-berjalan">
         <marquee scrolldelay="10" style="word-spacing: 5px;">MONITORING SUHU DAN KELEMBABAN LABORATORIUM OSEANOGRAFI FISIS DAN SAINS ATMOSFER JURUSAN FISIKA FAKULTAS MATEMATIKA DAN ILMU PENGETAHUAN ALAM UNIVERSITAS  SRIWIJAYA INDERALAYA</marquee><!-- <p><div class="logout"><a id="logout" href="logout.php">LOGOUT</a></div></p> -->
      </div> 
       <nav>
        <ul>
          <li  id="hover"><a href="index.php">HOME</a></li>
          <li  class="active" id="hover"><a href="dataharian.php">DATA HARIAN</a></li>
          <li  id="hover"><a href ="details.php">DETAILS</a></li>
        </ul>
    </nav>

      
  </header>

  <main>
    <div class="box">
      <ul syle="list-style:none;">
      <li style="display:inline;margin-left:0px;"><a style="text-decoration:none;color:white;background-color:#337AB7;padding:5px;border-radius:6px;" href="dataharian.php">Data Harian</a></li>
      <li style="display:inline;margin-left:20px;"><a style="text-decoration:none;color:white;background-color:#337AB7;padding:5px;border-radius:6px;" href="datamingguan.php">Data Mingguan</a></li>
      <li style="display:inline;margin-left:20px;"><a style="text-decoration:none;color:white;background-color:#337AB7;padding:5px;border-radius:6px;" href="databulanan.php">Data Bulanan</a></li>
      </ul>
      <div id="cards" class="cards" align="center">
      
        <table id="wnntable" style="border-radius: 12px;">
          <tr>
            <th colspan="4" style="text-align: center; background-color: #413C69;  border-top-right-radius: 12px;
                          border-top-left-radius: 12px;">
            Data Sensor Suhu Dan Kelembaban Jurusan Fisika Universitas Sriwijaya
            </th>
          </tr>
          <tr >
            <th>No</th>
            <th>Suhu</th>
            <th>Kelembaban</th>
            <th>Waktu</th>
          </tr>
          <?php
          $tgl_hari_ini=date("Y-m-d");
          $tampil = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE id IN (SELECT MAX(id) FROM datasensor)");
          $data = mysqli_fetch_array($tampil); 
          
           ?>

          <?php $jumlahdataperhalaman = 5;
          $jumlahdata = count(query("select tgl_hari_ini, count(*) as jumlah from datasensor group by tgl_hari_ini ORDER BY id DESC"));
          // echo $jumlahdata;
          // die();
          $jumlahhalaman = ceil($jumlahdata/$jumlahdataperhalaman);
          // echo $jumlahhalaman;
          // die();
          $halamanaktif = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
          $awaldata = ($jumlahdataperhalaman * $halamanaktif) - $jumlahdataperhalaman;
          $show = query("select tgl_hari_ini as tgl, count(*) as jumlah,AVG(suhu) as temp,AVG(kelembaban) as humi from datasensor group by tgl_hari_ini ORDER BY id DESC LIMIT $awaldata, $jumlahdataperhalaman");
          $i= 1 + $awaldata;
          $jumlahlink = 4;
          if($halamanaktif > $jumlahlink)
          {
              $start_number = $halamanaktif - $jumlahlink;
          }
          else
          {
              $start_number = 1;
          }
          if($halamanaktif < ($jumlahhalaman - $jumlahlink))
          {
              $end_number = $halamanaktif + $jumlahlink;
          }
          else
          {
              $end_number = $jumlahhalaman;
          }
          foreach($show as $data) :
           ?>

          <tr>
            <td><?= $i;?></td>
            <td><?=number_format($data['temp']) ?>&deg;C</td>
            <td><?=number_format($data['humi']) ?>%</td>
            <td><?=$data['tgl'] ?></td>
          </tr>
          
          <?php $i++; ?>
          <?php endforeach; ?>
        </table>

        <a target="_blank" href="export_excel.php" style="float: right; margin-top: 5px;"><img class="mb-4" src="assets//img/printing.png" width="25" style="float: right;"></a>
          
        <!-- navigator -->
        

        <div class="navigator" style="margin-top: 20px; margin-bottom: 0px; text-align: center; ">
            <?php if($halamanaktif > 1): ?>
                <a href="?hal=<?=$halamanaktif-1; ?>" style="font-size:12px; color: white; text-decoration: none; margin-right: 20px;" > Previous </a>
            <?php endif; ?>
            <?php if($halamanaktif > 3): ?>
                <a href="?hal=<?=1 ?>" style="font-weight: bold; font-size:12px; color: white; text-decoration: none; margin-right: 15px;"> << </a>
            <?php endif; ?>    
            <?php for($i=$start_number; $i <= $end_number; $i++) : ?>
                <?php if($i == $halamanaktif) : ?>
                    <a href="?hal=<?=$i;?>" style="font-weight: bold; font-size: 12px;text-decoration: none; margin-right: 15px;"><?=$i;?></a>
                <?php else : ?>
                    <a href="?hal=<?=$i;?>" style="color: white; font-size: 12px; text-decoration: none; margin-right: 15px;"><?=$i;?></a>
                <?php endif; ?>
            <?php endfor; ?>
               <?php if($halamanaktif < $jumlahhalaman): ?>
                <a href="?hal=<?=$jumlahhalaman ?>" style="font-weight: bold; font-size:12px; color: white; text-decoration: none; margin-right: 20px;"> >> </a>
            <?php endif; ?>
            <?php if($halamanaktif < $jumlahhalaman): ?>
                <a href="?hal=<?=$halamanaktif+1; ?>" style="font-size:12px; color: white; text-decoration: none;"> Next </a>
            <?php endif; ?>
            </div>


      </div>
    </div>
  <footer> Laboratorium Oseanografi Fisis Dan Sains Atmosfer, Jurusan Fisika &#169; 2021, 
      Fakultas Matematika dan Ilmu Pengetahuan Alam &copy; 2021, Universitas Sriwijaya, Inderalaya <br><span><a style="color: white;" href="logout.php" ><i>logout</i></a></span></footer>  
  </main>
</body>
</html>


