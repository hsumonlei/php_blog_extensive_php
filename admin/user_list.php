<?php
session_start();
require '../config/config.php';


if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
 header('Location:login.php');
}

if(!empty($_GET['pageno'])){
  $pageno = $_GET['pageno'];
}else{
  $pageno = 1;
}

//offset is starting from zero
$numberOFrecs = 3;
$offset=($pageno - 1) * $numberOFrecs;

if(empty($_POST['search'])){
  
$pdostatement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
$pdostatement->execute();

$raw_result = $pdostatement->fetchAll();
//print_r(count($result));
$total_pages = ceil(count($raw_result)/$numberOFrecs);

//for offset extraction
$pdostatement = $pdo->prepare("SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numberOFrecs ");
$pdostatement->execute();

$result = $pdostatement->fetchAll();
}else{
  $searchKey = $_POST['search'];
  $pdostatement = $pdo->prepare("SELECT * FROM users WHERE  title LIKE '%$searchKey%' ORDER BY id DESC");

  //print_r($pdostatement);
  $pdostatement->execute();
  
  $raw_result = $pdostatement->fetchAll();
  //print_r(count($result));
  $total_pages = ceil(count($raw_result)/$numberOFrecs);
  
  //for offset extraction
  $pdostatement = $pdo->prepare("SELECT * FROM users WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numberOFrecs ");
  $pdostatement->execute();
  
  $result = $pdostatement->fetchAll();
}

?>

<?php
include 'header.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" >
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">User Listings</h1>
        <div class="card">
          <div class="card-header">
            <!-- <h3 class="card-title">Striped Full Width Table</h3> -->
            <div class=""> 
              <a href="user_add.php" type="button" class="btn btn-success">Create User</a><br>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">             
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th style="width: 40px">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php 
              if ($result) {
                $i = 1;
                foreach ($result as $value) { 
              ?>
                  <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $value['name'] ?></td>
                    <td><?php echo $value['email'] ?></td>
                    <td><?php echo $value['role'] == 1 ? 'admin' : 'user'; ?></td>

                    <td>
                      <div class="btn-group">
                        <div class="container">
                          <a href="user_edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-warning">Edit</a>
                        </div>
                        <div class="container">
                          <a href="delete.php?id=<?php echo $value['id'] ?>" 
                          onClick="return confirm('Are you sure you want to delete this item')" type="button" class="btn btn-danger">Delete</a>
                        </div>
                      </div>
                    </td>
                </tr>

                <?php
                $i++;
                }
               
              }
              ?>
              
              </tbody>
            </table><br/>
            <nav aria-label="Page navigation example" style="float:right">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                <li class="page-item  <?php if($pageno <= 1) { echo 'disabled';} ?>" >
                  <a class="page-link" href="<?php if($pageno <= 1) {echo '#';}else{echo "?pageno=".($pageno-1);}?>">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?> </a></li>
                <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                  <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';} else{ echo "?pageno=".($pageno+1);}?>">Next</a></li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
              </ul>
            </nav>
          </div>
          <!-- /.card-body -->
        </div>
      </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php 
include 'footer.html';
?>
