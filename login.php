<?php 
  include 'config/connection.php';
  include 'config/global_function.php';
  date_default_timezone_set('Asia/Jakarta');

  if (isset($_POST['submit'])) {
    $u = $_POST['username'];
    $p = encrypt_decrypt('encrypt', $_POST['password']);
    $date_now = date('Y-m-d H:i:s');
    
    $cek_login = mysqli_query($conn, "SELECT * FROM login WHERE BINARY username='$u' AND password='$p'");
    $data = mysqli_fetch_array($cek_login);
    $hitung = mysqli_num_rows($cek_login);
    $token_gen = encrypt_decrypt('encrypt', $data['id']);

    if ($hitung > 0) {
      setcookie('user_dashboard', $token_gen, time() + (86400 * 30), "/");
    } 
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | Dashboard App</title>
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="main-panel">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                  <h2><b>SPK AHP-VIKOR</b></h2>
                </div>
                <h4>Hello! Selamat datang di Dashboard App</h4>
                <h6 class="font-weight-light">Silahkan login terlebih dahulu untuk melanjutkan</h6>
                <form class="pt-3" action="login.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Username" name="username">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" placeholder="Password" name="password">
                  </div>
                  <div class="mt-3">
                    <input type="submit" name="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="LOGIN">
                  </div>
                  <?php 
                  
                    if (isset($_POST['submit'])) {
                      $u = $_POST['username'];
                      $p = encrypt_decrypt('encrypt', $_POST['password']);
                      $date_now = date('Y-m-d H:i:s');
                      
                      $cek_login = mysqli_query($conn, "SELECT * FROM login WHERE BINARY username='$u' AND password='$p'");
                      $data = mysqli_fetch_array($cek_login);
                      $hitung = mysqli_num_rows($cek_login);
                  
                      if ($hitung > 0) {
                        echo '<div class="mt-3 badge-success p-2 text-center rounded-1">Login berhasil</div>';
                        echo "<meta http-equiv='refresh' content='1;
                          url=index.php?page=beranda'>";
                      } else {
                        echo '<div class="mt-3 badge-danger p-2 text-center rounded-1">Login gagal, cek kembali username dan password anda</div>';
                      }
                    }
                    
                  ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <script src="js/template.js"></script>
</body>

</html>
