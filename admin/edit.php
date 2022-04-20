<?php
session_start();

require '../config/config.php';



if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
 header('Location: login.php');
}

if ($_SESSION['role'] != 1) {
    header('Location:login.php');
  }

if ($_POST) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    if ($_FILES['image']['name'] != null) {
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);
        // print "<pre>";
        // print_r($file);
    
    
        if ($imageType != 'png' && $imageType != 'jpg' &&  $imageType != 'jpeg') {
            echo "<script>alert('Image must be png, jpg and jpeg');</script>";
        }else{

            $image = $_FILES['image']['name'];
    
            // print "<pre>";
            // print_r($image);
            
            move_uploaded_file($_FILES['image']['tmp_name'],$file);
    
            $pdostatment = $pdo->prepare("UPDATE posts SET title='$title',content='$content',image='$image' WHERE id='$id'");
    
            $result = $pdostatment->execute();
    
            if($result){
                echo "<script>alert('Successfully Updated!');</script>";
                header('Location: index.php');
            }
    
        }
    }else{
        $pdostatment = $pdo->prepare("UPDATE posts SET title='$title',content='$content' WHERE id='$id'");
    
            $result = $pdostatment->execute();
    
            if($result){
                echo "<script>alert('Successfully Updated!');</script>";
                header('Location: index.php');
            }

    }
 
}

$pdostatement = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);

$pdostatement->execute();

$result= $pdostatement->fetchAll();
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
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label><br>
                            <textarea name="content" class="form-control" id="" cols="100" rows="10"><?php echo $result[0]['content'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label><br>
                            <img src="images/<?php echo $result[0]['image'] ?>" width="100" height="100" alt=""><br/>
                            <input type="file" name="image">
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

