<?php

function upload_files() {
    $uploadOK = 1;
    $targetDir = "public/img/";
    $files = [];

    foreach($_FILES['images']['name'] as $key => $file){
      $fileName = uniqid() . '_' . $file;
      echo $fileName .'</br>';

      $files[] = $fileName;
      move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetDir . $fileName);
    }
}

if(isset($_POST['add-product'])) {
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $files = upload_files();

    //DB::insert('products', 'name, price, description', "'$name', '$price', '$description'");
    $mssg = 'Product added successfully!';
}

?>


<form id="add-product-form">
    <h2>Add a product</h2>
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="price" placeholder="Price">
    <textarea name="description" placeholder="Description" rows="8"></textarea>
    <input type="file" name="images[]" id="upload-images" multiple>
    <div class="upload-image-grid">
    </div>
    <input type="submit" name="add-product" value="Add Product">
    <p id="result-message"></p>
</form>
