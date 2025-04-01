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
$dsn = 'mysql:host=' . $host . ';dbname=' . $database;

//$conn = mysqli_connect($host, $user, $password, $database);

try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection error: " . $e->getMessage());
}

if(!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

include(get_dir() . '/classes/db.php');





?>
