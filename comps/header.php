<?php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/fd483a54f1.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="public/css/style.css?v=<?php echo filemtime('public/css/style.css')?>">


    <title>Commerce</title>
</head>
<body>

<div id="header">
    <div class="w-100 row space-around al-c">
        <a class="btn" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
        <h1>THNGS.</h1>
        <a class="btn" href="?page=cart"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
    <ul id="nav">
        <li> <a href="?page=home">Home</a> </li>
        <li> <a href="?page=products">Products</a> </li>
        <li> <a href="?page=contact">Contact</a> </li>
    </ul>
    <div class="row">
    </div>
</div>
