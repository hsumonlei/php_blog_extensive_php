<?php

session_start();
require 'config/config.php';

if ($_POST) {
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 6) {
    if(empty($_POST['name'])) {
        $nameError = "name cannot be null";
    }
    if(empty($_POST['email'])) {
        $emailError = "Email Required";
    }
    if(empty($_POST['password'])) {
        $pwdError = "Password cannot be null";
    }
    if (strlen($_POST['password'])<6) {
        $pwdError = "Password should be 6 characters length at least";
    }
  }else{
    $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
  

  $pdostatement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
  
 $pdostatement->bindValue(':email',$email);
 $pdostatement->execute();
 $user = $pdostatement->fetch(PDO::FETCH_ASSOC);

 //print_r($user);
 if($user){
     echo "<script>alert('Insert New user with new email');</script>";
 }else{

    $pdostatment = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password, :role)");

    $pdostatment->bindValue(':name',$name);
    $pdostatment->bindValue(':email',$email);
    $pdostatment->bindValue(':password',$password);
    $pdostatment->bindValue(':role',0);


    $result = $pdostatment->execute();

    if($result){
        echo "<script>alert('Successfully Registered! You can now Login!'); window.location.href='login.php';</script>";
    }

 }
  }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Blog</b>User</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register New Account</p>

      <form action="register.php" method="post">
      <p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
      <div class="input-group mb-3">
          <input type="name" name="name" class="form-control" placeholder="Name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <p style="color:red;"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <p style="color:red;"><?php echo empty($pwdError) ? '' : '*'.$pwdError; ?></p>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <a type="button" class="btn btn-default btn-block" href="login.php">Login</a>
          </div>
          <!-- /.col -->
        </div>
      </form>


      <!-- /.social-auth-links -->
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src=".././js/adminlte.min.js"></script>
</body>
</html>
