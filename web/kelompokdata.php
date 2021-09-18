<?php
date_default_timezone_set('Asia/Jakarta');
$tanggalserver = date('Y-m-d');
$jamserver = date('H:i:s');

$server		= "localhost"; 
$user 		= "root";
$pass 		= ""; 
$database 	= "tugasakhir"; 
$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));
?>
    <center>
        <h1>Semua Data</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tanggal </center></th>
                <th><center> Waktu </center></th>
                <th><center> Suhu </center></th>
                <th><center> Kelembaban </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select * from datasensor");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tgl_hari_ini']; ?> </center></td>
                <td><center> <?php echo $d['time']; ?> </center></td>
                <td><center> <?php echo $d['suhu']; ?> </center></td>
                <td><center> <?php echo $d['kelembaban']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>

    <center>
        <h1>Data Harian</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tanggal </center></th>
                <th><center> Suhu </center></th>
                <th><center> Kelembaban </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select * from datasensor");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tgl_hari_ini']; ?> </center></td>
                <td><center> <?php echo $d['suhu']; ?> </center></td>
                <td><center> <?php echo $d['kelembaban']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>

    <center>
        <h1>Jumlah Data Per Hari Pada Tabel_Data</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tanggal </center></th>
                <th><center> Suhu </center></th>
                <th><center> Jumlah Data </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select tgl_hari_ini, count(*) as jumlah,SUM(suhu) as temp from datasensor group by tgl_hari_ini");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tgl_hari_ini']; ?> </center></td>
                <td><center> <?php echo number_format($d['temp'],2); ?> </center></td>
                <td><center> <?php echo $d['jumlah']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>

    <center>
        <h1>Jumlah Data Per Minggu Pada Tabel_Data</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tahun / Minggu Ke- </center></th>
                <th><center> Suhu </center></th>
                <th><center> Kelembaban </center></th>
                <th><center> Jumlah Data </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select concat(year(tgl_hari_ini),' / ',week(tgl_hari_ini)) as tahun_minggu, count(*) as jumlah,AVG(suhu) as temp,AVG(kelembaban) as humi from datasensor group by year(tgl_hari_ini),week(tgl_hari_ini)");
            // $datas = mysqli_query($koneksi,"select concat(year(tgl_hari_ini),' / ',week(tgl_hari_ini)) as tahun_minggus, SUM(kelembaban) as humi from datasensor group by year(tgl_hari_ini),week(tgl_hari_ini)");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tahun_minggu']; ?> </center></td>
                <td><center> <?php echo number_format($d['temp'],2); ?> </center></td>
                <td><center> <?php echo number_format($d['humi'],2); ?> </center></td>
                <td><center> <?php echo $d['jumlah']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>

    <center>
        <h1>Jumlah Data Per Bulan Pada Tabel_Data</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tahun / Bulan Ke- </center></th>
                <th><center> Suhu </center></th>
                <th><center> Jumlah Data </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select concat(year(tgl_hari_ini),' / ',month(tgl_hari_ini)) as tahun_bulan, count(*) as jumlah,SUM(suhu) as temp from datasensor group by year(tgl_hari_ini),month(tgl_hari_ini)");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tahun_bulan']; ?> </center></td>
                <td><center> <?php echo number_format($d['temp'],2); ?> </center></td>
                <td><center> <?php echo $d['jumlah']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>

    <center>
        <h1>Jumlah Data Per Tahun Pada Tabel_Data</h1>
        <table border="1">
            <tr>
                <th><center> No </center></th>
                <th><center> Tahun </center></th>
                <th><center> Suhu </center></th>
                <th><center> Jumlah Data </center></th>
            </tr>
            <?php 
            $data = mysqli_query($koneksi,"select year(tgl_hari_ini) as tahun, count(*) as jumlah,SUM(suhu) as temp from datsensor group by year(tgl_hari_ini)");
            $no = 1;
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><center> <?php echo $no++; ?> </center></td>
                <td><center> <?php echo $d['tahun']; ?> </center></td>
                <td><center> <?php echo number_format($d['temp'],2); ?> </center></td>
                <td><center> <?php echo $d['jumlah']; ?> </center></td>
            </tr>
            <?php 
            }
            ?>
        </table>
    </center>