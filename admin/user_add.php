<?php
session_start();

require '../config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
 header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
    header('Location:login.php');
}

if($_POST) {
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
        $password = $_POST['password'];

        

        if(empty($_POST['role'])) {
            $role = 0;
        }else{
            $role = 1;
        }
        
        $pdostatement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    
        $pdostatement->bindValue(':email',$email);
        $pdostatement->execute();
        $user = $pdostatement->fetch(PDO::FETCH_ASSOC);

       
    
        if($user) {
            echo "<script>alert('Email Duplicated');</script>";
        }else{
            echo "Start insert into table";
            $pdostatement= $pdo->prepare("INSERT INTO users(name,email,role,password) VALUES(:name, :email, :role, :password)");
            $pdostatement->bindValue(':name',$name);
            $pdostatement->bindValue(':email',$email);
            $pdostatement->bindValue(':password',$password);
            $pdostatement->bindValue(':role',$role);
            $result = $pdostatement->execute();
    
            if($result) {
                echo "<script>alert('Successfully added New User!');window.location.href='user_list.php' </script>";
            }  
        }
    }
}
?>

<?php

include 'header.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
  
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
     <div class="row">
         <div class="col-md-12">
             <div class="card">
                <div class="card-body">
                    <form class="" action="user_add.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label><p style="color:red;"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                            <input type="text" class="form-control" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label><br><p style="color:red;"><?php echo empty($emailError) ? '' : '*'.$emailError; ?></p>
                            <input type="email" class="form-control" name="email" value="">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label><br><p style="color:red;"><?php echo empty($pwdError) ? '' : '*'.$pwdError; ?></p>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="Admin">Admin</label><br>
                            <input type="checkbox" name="role" value="1">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                            <a href="user_list.php" class="btn btn-warning">Back</a>
                        </div>
                    </form>
                </div>
             </div>
         </div>
 
         <!-- /.col-md-6 -->
     </div>
     <!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include 'footer.html';
?>