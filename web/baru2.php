<?php
  session_start();

 if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  } 

  include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
?>

<?php        
$tampil = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE id IN (SELECT MAX(id) FROM datasensor) limit 1");
$data = mysqli_fetch_assoc($tampil);
$datas = $data['suhu'];
echo $datas;
$ini_adalah_gambar = "jpg";
echo $ini_adalah_gambar;
$waktu = date('H:i');
if ($datas < 40 && $datas > 20 && $waktu >'00:00' && $waktu <'19:00' ) :?>
<img src="icons/03d.png">
<?php endif; ?>

<?php 
$mahasiswa = [
[
	"nama" => "Ryan Apratama",
	"nim" => "08021381", 
	"jurusan" => "Fisika", 
	"email"=> "ryanapratamaa@gmail.com",
	"tugas"=> [100,100,100],
	"gambar"=> "ryana.jpg"
],
[
	"nama"=> "Dyah Hapsari", 
	"nim"=> "08021371",
	"jurusan"=> "Pendidikan Kedokteran", 
	"email"=> "dyah@gmail.com",
	"gambar"=> "dyah.jpg"
],
];

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Daftar Mahasiswa</title>
	</head>
<body>

	<h1>Daftar Mahasiswa</h1>

<?php foreach ($mahasiswa as $mhs) :?>
	<ul>
		<li><img src="img/<?=$mhs["gambar"]; ?>"></li>
		<li>Nama:<?= $mhs["nama"]; ?></li>
		<li>NIM:<?= $mhs["nim"]; ?></li>
		<li>Jurusan:<?= $mhs["jurusan"]; ?></li>
		<li>email:<?= $mhs["email"]; ?></li>
	</ul>
<?php endforeach; ?>
</body>
</html>













