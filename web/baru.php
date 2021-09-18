<?php
  session_start();

 if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  } 

  include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
?>

<?php 
            
            $data100 = mysqli_query($koneksi,"select waktu WHERE waktu='".$tgl_hari_ini."', count(*) as jumlah,SUM(suhu) as totaldatasuhu from datasensor group by waktu");
            $no = 1;
            while($d = mysqli_fetch_array($data100)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['waktu']; ?> </center></td>
                <td><center> <?php echo number_format($d['totaldatasuhu'],2); ?> </center></td>
                <td><center> <?php echo $d['jumlah']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>

                <?php
                date_default_timezone_set('Asia/Jakarta');
                $tgl_hari_ini=date("Y-m-d");
                $show= mysqli_query($koneksi," SELECT*FROM datasensor WHERE waktu='$tgl_hari_ini' ORDER BY suhu DESC");
                $datas = mysqli_fetch_assoc($show);
                ?>

$result= mysqli_query($conn, "SELECT AVG(orders) AS average FROM penjualan");
$row = mysqli_fetch_assoc($result);
$average = $row['average'];
echo ("Nilai Rata-Rata nya adalah: $average");

SELECT AVG(harga)

FROM pembelian

WHERE pembeli="Cecep Sukhoi"

