<?php

function upload_files() {
    global $images;
    foreach($images as $image) {
        $file = 'public/img/' . $image;
        if(file_exists($file)) {
            unlink($file);
        }
    }
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

if(!isset($_GET['id'])) {
    header('Location: admin.php?page=products');
}
$product = $productModel->getProduct([]);
if(!isset($product)) {
    header('Location: admin.php?page=products');
}

if(isset($_POST['edit-product'])) {
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    if(!is_numeric($price)) {
        $price = 0;
    }
    $quantity = htmlspecialchars($_POST['quantity']);
    if(!is_numeric($quantity)) {
        $quantity = 0;
    }
    $description = htmlspecialchars($_POST['description']);
    $files = upload_files();

    DB::update('products',
    "name = '$name', price = '$price', quantity = '$quantity' description = '$description'",
    "ID = '$productID'");
    $mssg = 'Product added successfully!';
}


$images = json_decode($product['images'], true);

?>


<form id="add-product-form">
    <h2>Edit a product</h2>
    <input type="text" name="name" placeholder="Name" value="<?php echo $product['name'] ?>">
    <input type="text" name="price" placeholder="Price" value="<?php echo $product['price'] ?>">
    <input type="number" name="quantity" placeholder="Quantity" value="<?php echo $product['quantity'] ?>">
    <textarea name="description" placeholder="Description" rows="8"><?php echo $product['description'] ?></textarea>
    <div class="file-upload-wrapper">
        <label for="upload-images" class="upload-file">Add Images</label>
        <input type="file" name="images[]" id="upload-images" multiple>
    </div>
    <div class="upload-image-grid">
        <?php foreach($images as $image): ?>
        <div class="upload-image-wrapper" draggable>
            <img src="public/img/<?php echo $image ?>" alt="">
        </div>
        <?php endforeach; ?>
    </div>
    <input type="submit" name="edit-product" value="Save">
    <p id="result-message"></p>
</form>
