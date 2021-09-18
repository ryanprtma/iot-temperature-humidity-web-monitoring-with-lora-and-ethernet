<?php
 
    //Variabel database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tugasakhir";
 
    $conn = mysqli_connect("$servername", "$username", "$password","$dbname");
 
    // Prepare the SQL statement
    $suhu=$_GET['suhu']//suhu adalah variabel pada arduino yang akan di upload pada url $suhu disini adalah variabel pada url yang akan dipanggil dan diupdate pada databae
    $kelembaban=$_GET['kelembaban']
    $result = mysqli_query ($conn,"INSERT INTO datasensor (data) VALUES ('$suhu', '$kelembaban')");//pemanggilan variabel $suhu yang telah dideklarasikan sebelumnya
    
    if (!$result) 
        {
            die ('Invalid query: '.mysqli_error($conn));
        }  