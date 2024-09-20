<?php
require('database.php');

// Get the product ID
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);
if ($product_id == null || $product_id == false) {
    $error_message = "Invalid product ID.";
    include('database_error.php');
    exit();
}
// Fetch the product details
$queryProduct = 'SELECT * 
                 FROM products 
                 WHERE productID = :product_id';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

// Fetch the catagories from a dropdown
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Product Manager</h1></header>

    <main>
        <h1>Edit Product</h1>
        <form action="edit_product.php" method="post" class="product_form">
              <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

            <label>Category:</label>
            <select name="category_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
            </select><br>

            <label>Code:</label>
            <input type="text" name="code" value="<?php echo $product['productCode']; ?>"><br>

            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $product['productName']; ?>"><br>

            <label>List Price:</label>
            <input type="text" name="price" value="<?php echo $product['listPrice']; ?>"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Update Product"><br>
        </form>
        <p><a href="index.php">View Product List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>