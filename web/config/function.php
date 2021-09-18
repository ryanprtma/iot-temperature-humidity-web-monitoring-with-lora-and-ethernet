<?php 
require"koneksi.php";
function query($query)
{
	global $koneksi;
	$result = mysqli_query($koneksi, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result))
	{
		$rows[] = $row;
	}
return $rows;
}

function registrasi($data)
{
	global $koneksi;
	// strtolower berfungsi untuk memaksa huruf besar menjadi huruf kecil
	// stripslashes berfungsi untuk menghlangkan karakter seperti slash(/) dan sebagainya
	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($koneksi, $data["password"]);
	$password2 = mysqli_real_escape_string($koneksi, $data["password2"]);
	// cek username sudah ada atau belum
	$result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username' ");
	if ( mysqli_fetch_assoc($result) )
	{
		echo "<script>
				alert('username sudah terdaftar');
				</script>";
		return false;
	}
	// cek konfirmasi password
	if ( $password !== $password2 )
	{
		echo "<script>
				alert('Konfirmasi Password Tidak Sesuai');
				</script>";
		return false;
	}
	// enkripsi password (mengamankan pasword)
	$password = password_hash($password, PASSWORD_DEFAULT);
	// tambahkan userbaru kedalam database
	mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password')");
	return mysqli_affected_rows($koneksi);
}

function getcsv($no_of_field_names)
{
	$separate = '';
	// do the action for all field names as field name
	foreach ($no_of_field_names as $field_name)
	{
		if (preg_match('/\\r|\\n|,|"/', $field_name))
		{
			$field_name = '' . str_replace('', $field_name) . '';
		}
		echo $separate . $field_name;
		//sepearte with the comma
		$separate = ',';
	}
	//make new row and line
	echo "\r\n";
}

?>
