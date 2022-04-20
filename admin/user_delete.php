<?php

require '../config/config.php';

// print "<pre>";
// print_r($_GET['id']);

$pdostatement = $pdo->prepare("DELETE FROM users WHERE id=".$_GET['id']);
$pdostatement->execute();


echo "<script>alert('Successfully delete!');</script>";

header('Location:user_list.php');
?>