<?php 
session_start();
include "config/koneksi.php";
include "config/function.php";
if( isset($_POST["register"]) )
{
	if( registrasi($_POST) > 0 )
	{
    header('Location:index.php');
	}
	else
	{
		echo mysqli_error($koneksi);
	}
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Sundeyyweather - Register</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/floating-labels.css" rel="stylesheet">
  </head>
  <body>
  <form class="form-signin" method="post" action="">
  <div class="text-center mb-4">
    <img class="mb-4" src="assets/img/logo2.jpg" width="100">
    <img class="mb-4" src="assets/img/logo1.jpg" width="35">
    <h1 class="h3 mb-3 font-weight-normal">Registrasi</h1>
    <p>Registrasikan diri anda untuk mendapatkan hak akses</p>
  </div>
  <div class="form-label-group">
    <input type="text" id="username" name="username" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputEmail">Username</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    <label for="inputPassword">Password</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="password2" name="password2" class="form-control" placeholder="Konfirmasi Password" required>
    <label for="inputPassword2">Konfirmasi Password</label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Registrasi</button>
  <p class="mt-5 mb-3 text-muted text-center">&copy; 2021 Fisika</p>
</form>
</body>
</html>
