<?php

require '../config/config.php';

// print "<pre>";
// print_r($_GET['id']);

$pdostatement = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
$pdostatement->execute();

header('Location:index.php');
?>