<?php
session_start();

require '../config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
 header('Location: login.php');
}

if($_POST){   
    // print "<pre>";
    // print_r($_FILES['image']);

    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);
    // print "<pre>";
    // print_r($file);


    if ($imageType != 'png' && $imageType != 'jpg' &&  $imageType != 'jpeg') {
        echo "<script>alert('Image must be png, jpg and jpeg');</script>";
    }else{
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];

        // print "<pre>";
        // print_r($image);
        
        move_uploaded_file($_FILES['image']['tmp_name'],$file);

        $pdostatment = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES(:title,:content,:image,:author_id)");

        $pdostatment->bindValue(':title',$title);
        $pdostatment->bindValue(':content',$content);
        $pdostatment->bindValue(':image',$image);
        $pdostatment->bindValue(':author_id',$_SESSION['user_id']);

        $result = $pdostatment->execute();

        if($result){
            echo "<script>alert('Successfully Added!');</script>";
            header('Location: index.php');
        }

    }
}
?>


<?php

include 'header.html';
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
                    <form class="" action="add.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label><br>
                            <textarea name="content" class="form-control" id="" cols="100" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label><br>
                            <input type="file" name="image" required>
                        </div>
                        <div class="form-group">
                            <input type="submit"  class="btn btn-success" value="Submit">
                            <a href="index.php" class="btn btn-warning">Back</a>
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

