<?php 
session_start ();
include "config/koneksi.php";
// cek cookie
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) )
{
  $id = $_COOKIE['id'];
  $key = $_COOKIE['key'];
  // ambil username berdasarkan id
  $result = mysqli_query($koneksi, "SELECT username FROM user WHERE id = $id");
  $row = mysqli_fetch_assoc($result);
  // cek cookie dan username
  if ( $key === hash('sha256', $row['username']) ) 
  {
    $_SESSION['login'] = true;
  }
}

if( isset($_SESSION["login"]) )
{
  header("Location: index.php");
  exit;
}

if( isset($_POST["login"]) )
{
  $username = $_POST["username"];
  $password = $_POST["password"];
  $result = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' ");
  if( mysqli_num_rows($result) === 1)
  {
    // cek password
    $row = mysqli_fetch_assoc($result);
    if ( password_verify($password, $row["password"]) )
    {
      //set session
      $_SESSION["login"] = true;
      // cek remember me
      if( isset($_POST["remember"]) )
      {
        // buat cookie
        setcookie('id', $row['id'], time()+60);
        setcookie('key', hash('sha256', $row['username']), time()+60); // hash adalah teknik mengacak
      // }
      header("Location: index.php");
      exit;
    }
  }
  $error = true;
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
    <title>Sundeyyweather - Login</title>
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
    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    <p>Silahkan masukkan username dan password anda</p>
    <?php if( isset($error) ) : ?>
    <p style="color: red; font-style: italic;">username / password salah !</p>
    <?php endif; ?>
  </div>
  <div class="form-label-group">
    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
    <label for="username">Username</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
    <label for="password">Password</label>
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me" name="remember"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
  <p class="mt-5 mb-3 text-muted text-center">&copy; 2021 Fisika</p>
</form>
</body>
</html>