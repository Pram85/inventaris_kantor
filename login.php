<?php
session_start();
include ('config/conn.php');
$base_url= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base_url.= "://".$_SERVER['HTTP_HOST'];
$base_url.= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

if(isset($_POST['cek_login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) && empty($password)){
        $error = 'Harap isi username dan password';
    }else{
        $user = mysqli_query($con,"SELECT * FROM users WHERE username='$username'") or die(mysqli_error($con));
        if(mysqli_num_rows($user)!=0){
            $data = mysqli_fetch_array($user);
                if(password_verify($password,$data['password'])){
                    $_SESSION['iduser'] = $data['id_users'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['fullname'] = $data['nama'];
                    $_SESSION['level'] = $data['level'];
                    header("Location:".$base_url);
                }else{
                    $error = 'Password anda salah';
                }
        }else{
            $error= 'Username tidak terdaftar';
        }
    }
    $_SESSION['error'] = $error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventaris Disdukcapil Ngawi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?=$base_url;?>assets/img/dispenduk.png">

    <!-- Custom fonts for this template-->
    <link href="<?=$base_url;?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=$base_url;?>assets/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #DFF8FF 0%, #b6e7ff 100%);
        }

        .login-container {
            min-height: 100vh;
        }

        .card {
            border-radius: 1.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-image {
            max-width: 80%;
            height: auto;
            margin: 2rem auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .login-image:hover {
            transform: scale(1.05);
        }

        .btn-login {
            background: linear-gradient(to right, #4e73df, #224abe);
            border: none;
            border-radius: 50px;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: linear-gradient(to right, #224abe, #1a3a94);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
        }

        .form-control-user {
            border-radius: 50px;
            padding: 1.5rem 1rem;
            border: 2px solid #e8f0fe;
            transition: all 0.3s ease;
        }

        .form-control-user:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .text-center h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .text-center p {
            color: #7b8a8b;
            margin-bottom: 2rem;
        }

        .card-body {
            background-color: #ffffff;
        }

        hr {
            border-top: 2px solid #f8f9fc;
            margin: 2rem 0;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center login-container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block text-center">
                                <div class="d-flex align-items-center justify-content-center h-100 p-4">
                                    <img src="<?=$base_url;?>assets/img/dispenduk.png" class="login-image" alt="Logo Dispenduk">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <?php if(isset($_SESSION['success'])):?>
                                    <div class="flash-data-berhasil" data-berhasil="<?= $_SESSION['success']; ?>"></div>
                                    <?php endif; unset($_SESSION['success']);?>
                                    <?php if(isset($_SESSION['error'])):?>
                                    <div class="flash-data-gagal" data-gagal="<?= $_SESSION['error']; ?>"></div>
                                    <?php endif; unset($_SESSION['error']);?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2"><b>WELCOME</b></h1>
                                        <p class="mb-4">Sistem Inventaris Disdukcapil Ngawi</p>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                placeholder="Masukkan username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" placeholder="Masukkan password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block btn-login"
                                            name="cek_login"><b>Login</b></button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?=$base_url;?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?=$base_url;?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?=$base_url;?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?=$base_url;?>assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?=$base_url;?>assets/js/sb-admin-2.min.js"></script>
    <script src="<?=$base_url;?>assets/js/demo/sweet-alert.js"></script>
</body>
</html>