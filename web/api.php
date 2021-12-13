
<?php
// session_start();

// if (!isset($_SESSION["login"])) {
//   header("Location: login.php");
//   exit;
// } 

include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
date_default_timezone_set('Asia/Jakarta');
$ID_arduino = isset($_POST['ID_dari_arduino_gate']) ? $_POST['ID_dari_arduino_gate'] : "";
$suhu = isset($_POST['suhu']) ? $_POST['suhu'] : "";
$kelembaban = isset($_POST['kelembaban']) ? $_POST['kelembaban'] : "";
$waktu = date('Y-m-d H:i:s');
$time = date("H:i:s");
$tgl_hari_ini=date("Y-m-d");

$sql_insert = "INSERT INTO datasensor (ID_dari_arduino_gate, suhu, kelembaban, waktu, time, tgl_hari_ini) VALUES ('$ID_arduino', '$suhu', '$kelembaban','$waktu','$time','$tgl_hari_ini')";

if(mysqli_query($koneksi, $sql_insert))
{
    // header("Location: login.php");
    // exit;
echo "Berhasil COK!";
mysqli_close($koneksi);
}
else
{
echo "error is ".mysqli_error($koneksi);
}
?>