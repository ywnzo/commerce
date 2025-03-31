<?php

if(!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1 || empty($_GET['id'])) {
    header('Location: index.php?page=home');
    exit;
}

$productID = $_GET['id'];
?>

<h2>Product</h2>
