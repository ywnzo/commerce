<?php

include_once('config/db_connect.php');

$isAdmin = false;
$mssg = '';

function getUserIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    //ip from share internet
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //ip pass from proxy
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

if(isset($_COOKIE['userID'])) {
    $userID = $_COOKIE['userID'];
    $sessionID = $_COOKIE['sessionID'];
    $ip = getUserIP();
    $user = DB::select('*', 'users', "ID = '$userID' AND sessionID = '$sessionID' AND sessionIP = '$ip'");
    if(isset($user['ID'])) {
        $isAdmin = true;
    }
}

if(!$isAdmin && isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    $sessionID = uniqid();
    $ip = getUserIP();

    $user = DB::select('*', 'users', "name = '$username'");
    if(!isset($user['ID'])) {
        return;
    }
    if(!password_verify($password, $user['password'])) {
        return;
    }
    DB::update('users', "sessionID = '$sessionID', sessionIP = '$ip'", "ID = '{$user['ID']}'");

    $isAdmin = password_verify($password, $user['password']);
    setcookie('userID', $user['ID'], time() + (86400 * 1), "/");
    setcookie('sessionID', $sessionID, time() + (86400 * 1), "/");
}

if(!$isAdmin) {
    return;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

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

    <script src="public/js/add_product.js" defer></script>

    <title>Commerce Admin</title>
</head>
<body>

    <div class="wrapper">
        <?php if(!$isAdmin): ?>
            <div class="admin-auth-wrapper">
                <form method="POST" class="login-form">
                    <h1>Admin</h1>
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" name="login" value="Login">
                </form>
                <p><?php echo $mssg ?></p>

            </div>
        <?php else: ?>
            <div class="admin-dashboard">
                <ul class="admin-side-panel">
                    <li><a href="?page=dashboard">Dashboard</a></li>
                    <li><a href="?page=products">Products</a></li>
                </ul>

                <div class="admin-content-wrapper">
                    <?php if($page == 'dashboard'): ?>
                        <h1 style="text-align: center;">Welcome, Admin!</h1>

                    <?php elseif($page == 'products'): ?>
                        <?php include_once('comps/admin/add_product.php') ?>

                        <?php include_once('comps/admin/product_table.php') ?>

                    <?php else: ?>
                    <?php endif; ?>
                    <p><?php echo $mssg ?></p>



                </div>




            </div>
        <?php endif; ?>
    </div>



</body>
</html>
