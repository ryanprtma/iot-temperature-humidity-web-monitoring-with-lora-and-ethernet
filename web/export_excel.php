<?php
  session_start();

 if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
  } 

  include "config/function.php"; // memanggil file koneksi.php untuk koneksi ke database
?>

<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel</title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;

	}
	tr:nth-child(even) {
		background-color: #ddd;
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>

	<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=datasensor.xls");
	?>

	<table border="1">
		<tr>
			<th colspan="4" style="text-align: center; background-color: blue;">
            Data Sensor Suhu Dan Kelembaban Jurusan Fisika Universitas Sriwijaya
            </th>
		</tr>
		<tr>
			<th>No</th>
			<th>Suhu</th>
			<th>Kelembaban</th>
			<th>Waktu</th>
		</tr>
		<?php
		// select tanggal hari ini
		$hari_ini=date("Y-m-d");

        $sql = mysqli_query($koneksi, "SELECT * FROM datasensor WHERE waktu='$hari_ini' ORDER BY id DESC");
 
        if(mysqli_num_rows($sql) == 0){
        	echo '<tr><td colspan="14">Data Tidak Ada.</td></tr>';
            // jika tidak ada entri di database maka tampilkan 'Data Tidak Ada.'
        }else{ // jika terdapat entri maka tampilkan datanya
       		$no = 1; // mewakili data dari nomor 1
        	while($row = mysqli_fetch_assoc($sql)){ // fetch query yang sesuai ke dalam array
		echo '
		<tr>
		  <td>'.$no.'</td>
		  <td>'.$row['suhu'].'</td>
		  <td>'.$row['kelembaban'].'</td>
		  <td>'.$row['waktu'].'</td>
		</tr>
        ';
       	$no++; // mewakili data kedua dan seterusnya
          }
        }
        ?>
	</table>
</body>
</html>