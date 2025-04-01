<?php

include_once '../config/db_connect.php';

function addProduct() {
    $name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : 'Unknown';
    $price = isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : 0;
    if(!is_numeric($price) || $price < 0){
        $price = 0;
    }
    $description = isset($_POST['description']) && !empty($_POST['description']) ? $_POST['description'] : '';
    $category = isset($_POST['category']) && !empty($_POST['category']) ? $_POST['category'] : 'Uncategorized';
    $images = isset($_FILES['images']) ? $_FILES['images'] : null;

    $uploadOK = 1;
    $targetDir = "../public/img/";
    $files = [];

    foreach($_FILES['images']['name'] as $key => $file){
      $fileName = uniqid() . '_' . $file;
      //echo $fileName .'</br>';

      $files[] = $fileName;
      if(!move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetDir . $fileName)){
        die('Error uploading file');
      }
    }

    $result = DB::insert('products', [
        'name' => htmlspecialchars($name),
        'price' => htmlspecialchars($price),
        'description' => htmlspecialchars($description),
        'category' => htmlspecialchars($category),
        'images' => json_encode($files)
    ]);

    if(!is_bool($result)) {
        echo 'Product added successfully';
    } else {
        echo $result;
    }
}

if(!isset($_POST['action'])) {
    die("Action not specified");
}

$action = $_POST['action'];

switch ($action) {
    case 'add':
        addProduct();
        break;
    case 'update':
        // Update product logic
        break;
    case 'delete':
        // Delete product logic
        break;
    default:
        die("Invalid action");
}

?>
