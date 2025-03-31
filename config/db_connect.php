<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function get_dir() {
    $root = $_SERVER['DOCUMENT_ROOT'];
    if(str_contains($root, 'ftpupload.net')) {
        return $root;
    } else {
        return $root . '/commerce';
    }
}

$config = parse_ini_file(get_dir() . '/config/config.ini', true);
$host = $config['db']['host'];
$user = $config['db']['user'];
$password = $config['db']['password'];
$database = $config['db']['database'];

$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

include(get_dir() . '/classes/db.php');





?>
