<?php

session_start();


$upIcon = ' &#x2191;';
$downIcon = '&#x2193;';

$productCount = DB::select('COUNT(ID) as count', 'products', "ID > 0")['count'];
$productCount = 512;
$resultCount = 16;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$maxOffset = ceil($productCount / $resultCount) - 1;
if($offset < 0 || $offset > $maxOffset) {
    $offset = 0;
}

$sortStates = isset($_SESSION['sortStates']) ? $_SESSION['sortStates'] : [
    "ID" => false,
    "name" => false,
    "price" => false,
    "quantity" => false
];

function getOrder($key) {
    global $sortStates;
    return $sortStates[$key] ? 'DESC' : 'ASC';
}

function getIcon($key) {
    global $upIcon, $downIcon, $sortStates;
    if(!isset($_POST['sort'])) {
        return '';
    }

    if($_POST['sort'] == $key) {
        return $sortStates[$key] ? $downIcon : $upIcon;
    } else {
        return '';
    }
}

function getMinOffset() {
    global $offset, $maxOffset;
    // Calculate the minimum offset while ensuring 5 items are displayed
    $minOffset = max(0, $offset - 2); // Start from 2 items before the current offset
    if ($offset + 2 > $maxOffset) {
        $minOffset = max(0, $maxOffset - 4); // Adjust when nearing the end
    }
    return $minOffset;
}

function getMaxOffset() {
    global $offset, $maxOffset;
    // Ensure the range always has 5 items
    $maxOffset = min($maxOffset, getMinOffset() + 4);
    return $maxOffset;
}


$sort = isset($_COOKIE['sort']) ? $_COOKIE['sort'] : 'ID';
if(isset($_POST['sort'])) {
    $sort = $_POST['sort'];
    $products = DB::select('*', 'products', "ID > 0 ORDER BY " . $sort . ' ' . getOrder($sort));
    $sortStates[$sort] = !$sortStates[$sort];
} else {
    $products = DB::select('*', 'products', "ID > 0 ORDER BY " . $sort . ' ' . getOrder($sort));
}

$_SESSION['sortStates'] = $sortStates;

?>

<div class="product-table-wrapper">
    <div class="w-100 row space-between">
        <h2>Your products</h2>
        <div class="search-wrapper">
            <input id="search-input" type="text" placeholder="Search...">
            <i id="search-icon" class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
    <table id="product-table">
        <thead>
            <form method="post">
                <th><button class="sort-button" name="sort" value="ID">ID <?php echo getIcon('ID') ?></button></th>
                <th><button class="sort-button" name="sort" value="name">Name <?php echo getIcon('name') ?></button></th>
                <th><button class="sort-button" name="sort" value="price">Price<?php echo getIcon('price') ?></button></th>
                <th><button class="sort-button" name="sort" value="quantity">Quantity <?php echo getIcon('quantity') ?></button></th>
                <th>Actions</th>
            </form>

        </thead>

        <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                    <td><?php echo $product['ID'] ?></td>
                    <td><?php echo $product['name'] ?></td>
                    <td><?php echo $product['price'] ?></td>
                    <td><?php echo $product['quantity'] ?></td>
                    <td>
                        <div class="row js-c-c" style="gap: 0.5rem;">
                            <a class="action-btn" href="?page=edit_product&id=<?php echo $product['ID'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="action-btn" href="?page=delete_product&id=<?php echo $product['ID'] ?>"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row js-c-c" style="gap: 0.5rem;">
        <a class="page-button" href="?page=products&offset=<?php echo $offset - 1 >= 0 ? $offset - 1 : 0 ?>"><</a>
        <div class="row al-c" style="gap: 0.2rem;">
            <?php for($i = getMinOffset(); $i <= getMaxOffset(); $i++): ?>
                <a class="<?php echo $i == $offset ? 'page-number-active' : 'page-number' ?>" href="?page=products&offset=<?php echo $i ?>">
                    <?php echo $i + 1 ?>
                </a>
            <?php endfor; ?>
        </div>
        <a class="page-button" href="?page=products&offset=<?php echo $offset + 1 < $maxOffset ? $offset + 1 : $maxOffset ?>">></a>
    </div>
</div>
