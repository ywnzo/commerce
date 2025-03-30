<?php

include_once('config/db_connect.php');
include_once('config/verify_login.php');

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>


<div id="wrapper">
    <?php 
        include_once('comps/header.php');

        switch ($page) {
            case 'home':
                include_once('comps/pages/home.php');
                break;
            case 'products':
                include_once('comps/pages/products.php');
                break;
            case 'cart':
                include_once('comps/pages/cart.php');
                break;
            case 'contact':
                include_once('comps/pages/contact.php');
                break;
            default:
                include_once('comps/pages/home.php');
                break;
        }

        include_once('comps/footer.php');
    ?>
</div>

