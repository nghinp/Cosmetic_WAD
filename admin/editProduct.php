<?php
include "../includes/database.php";
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = $_GET['id'];

// Fetch product data
$stmt = $connect->prepare("SELECT * FROM product WHERE ProductID = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $supplier = $_POST['supplier'];
    $oldPrice = $_POST['old_price'];
    $specialPrice = $_POST['special_price'];
    $quantity = $_POST['quantity'];
    $discount = $_POST['discount'];
    $status = $_POST['status'];
    $rating = $_POST['rating'];

    $imagePath = $product['ImageURL']; // Default to existing

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $filename = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $imagePath = substr($target_file, 3);
    }

    $stmt = $connect->prepare("UPDATE product SET ProductName=?, Description=?, Category=?, SupplierID=?, OldPrice=?, SpecialPrice=?, QuantityInStock=?, Discount=?, ImageURL=?, Rating=?, Status=?, Brand=? WHERE ProductID=?");
    $stmt->execute([$name, $desc, $category, $supplier, $oldPrice, $specialPrice, $quantity, $discount, $imagePath, $rating, $status, $brand, $id]);

    header("Location: adminProducts.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <div class="edit-form-wrapper">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data" class="edit-product-form">
            <label>Name:</label><input type="text" name="name" value="<?= $product['ProductName'] ?>" required>
            <label>Description:</label><input type="text" name="description" value="<?= $product['Description'] ?>">
            <label>Category:</label><input type="text" name="category" value="<?= $product['Category'] ?>">
            <label>Brand:</label><input type="text" name="brand" value="<?= $product['Brand'] ?>">
            <label>Supplier:</label><input type="text" name="supplier" value="<?= $product['SupplierID'] ?>">
            <label>Old Price:</label><input type="number" step="0.01" name="old_price" value="<?= $product['OldPrice'] ?>">
            <label>Special Price:</label><input type="number" step="0.01" name="special_price" value="<?= $product['SpecialPrice'] ?>">
            <label>Stock:</label><input type="number" name="quantity" value="<?= $product['QuantityInStock'] ?>">
            <label>Discount:</label><input type="number" step="0.01" name="discount" value="<?= $product['Discount'] ?>">
            <label>Image:</label><input type="file" name="image">
            <label>Status:</label><input type="text" name="status" value="<?= $product['Status'] ?>">
            <label>Rating:</label><input type="number" step="0.01" name="rating" max="5" value="<?= $product['Rating'] ?>">
            <button type="submit">Update Product</button>
        </form>
    </div>

</body>

</html>