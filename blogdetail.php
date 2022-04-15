<?php
require 'config/config.php';
session_start();

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
 }

$pdostatement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$pdostatement->execute();

$result= $pdostatement->fetchAll();


//print "<pre>";
//print_r($result);

//For comments
$blogId = $_GET['id'];
$authorId = $_SESSION['user_id'];

$cmt_pdostatement = $pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
$cmt_pdostatement->execute();

$cmt_result= $cmt_pdostatement->fetchAll();

//print "<pre>";
//print_r($cmt_result);

if($cmt_result){
$authorId = $cmt_result[0]['author_id'];

$au_pdostatement = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
$au_pdostatement->execute();

$au_result= $au_pdostatement->fetchAll();

}

if ($_POST) {
    $comment = $_POST['comment'];
    $pdostatment = $pdo->prepare("INSERT INTO comments(content,author_id,post_id) VALUES(:content,:author_id,:post_id)");
  
      $pdostatment->bindValue(':content',$comment);
      $pdostatment->bindValue(':author_id',$authorId);
      $pdostatment->bindValue(':post_id',$blogId);
  
  
      $result = $pdostatment->execute();
  
      if($result){
         header("Location:blogdetail.php?id=".$blogId);
      }
  
   }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<!-- Content Wrapper. Contains page content -->
<div class="">

    <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-widget">
                <div class="card-hearder">
                    
                    <div style="text-align:center !important; float:none" class="card-title">
                        <h4><?php echo $result[0]['title'] ?></h4>
                    </div>
                </div>

                <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']?>" >
                    <br>

                    <p><?php echo $result[0]['content']?></p>
                    <h3>Comments</h3><hr>

                </div>
                
                <?php
                if($cmt_result){
                  ?>
                <!-- /.card-body -->
                <div class="card-footer card-comments">
                    <div class="card-comment">
                        <div class="comment-text" style="margin-left: 0px !important;">
                        <span class="username">
                            <?php echo $au_result[0]['name'] ?>
                            <span class="text-muted float-right"><?php echo $cmt_result[0]['created_at'] ?></span>
                        </span><!-- /.username -->
                        <?php echo $cmt_result[0]['content'] ?>
                        </div>
                        <!-- /.comment-text -->
                    </div>
                <!-- /.card-comment -->
                    
                </div>
                <?php
                }
                ?>
                <!-- /.card-footer -->
                <div class="card-footer">
                    <form action="" method="post">
                        <!-- .img-push is used to add margin to elements next to floating images -->
                        <div class="img-push">
                        <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
                        </div>
                    </form>
                </div>
            <!-- /.card-footer -->
        
        </div>
    </div>
        <!-- /.card -->
</section>

</div>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="login.php" type="button" class="btn btn-default">logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022-2023 <a href="https://hsumonleiaung.w3spaces.com/">HsumonLei Aung</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
