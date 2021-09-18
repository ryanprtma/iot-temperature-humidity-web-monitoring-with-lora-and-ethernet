<?php
include "../config/koneksi.php";
include "../config/function.php";
date_default_timezone_set('Asia/Jakarta');
	$Tanggal = date("Y-m-d");
	$Waktu = date("H:i:s");
//header("Content-type: application/octet-stream");
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Data Monitoring $Tanggal.csv");
//select table to export the data
$select_table=mysqli_query($koneksi,"SELECT * FROM tbl_data");
$rows = mysqli_fetch_assoc($select_table);

if ($rows)
{
getcsv(array_keys($rows));
}
while($rows)
{
getcsv($rows);
$rows = mysqli_fetch_assoc($select_table);
}
?>