<?php
session_start();
include "../includes/database.php";

// Block non-admins
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../config/login.php");
    exit();
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: ../config/login.php");
    exit();
}

// Handle form submission to add new product
if (isset($_POST['add_product'])) {
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

    // Handle image upload
    $imagePath = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // create folder if not exists
        }
        $filename = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . time() . "_" . $filename; // unique name
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

        // Save relative path to DB
        $imagePath = substr($target_file, 3); // remove "../"
    }

    $stmt = $connect->prepare("INSERT INTO product 
        (ProductName, Description, Category, SupplierID, OldPrice, SpecialPrice, QuantityInStock, DateAdded, Discount, ImageURL, Rating, Status, Brand)
        VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $desc, $category, $supplier, $oldPrice, $specialPrice, $quantity, $discount, $imagePath, $rating, $status, $brand]);
}

// Fetch all products
$stmt = $connect->query("SELECT * FROM product ORDER BY Brand, Category");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products</title>
</head>
<body>
<nav>
    <div><img src="../assets/images/SetUpSprint.svg" class="logo" /></div>
    <div style="flex-basis: auto;">
        <form class="search-form">
            <input type="text" class="search-input" placeholder="Search...">
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>
    
</nav>

<div class="mpage">
    <div class="lfttable">
        <div class="tablrow">
            <div class="tablecol"><img src="../assets/images/dashboard.png"></div>
            <div class="tablecol"><a href="adminDashboard.php">Dashboard</a></div>
        </div>
        <div class="tablrow">
            <div class="tablecol"><img src="../assets/images/costumers.png"></div>
            <div class="tablecol"><a href="adminCostumers.php">Customers</a></div>
        </div>
        <div class="tablrow">
            <div class="tablecol"><img src="../assets/images/orders.png"></div>
            <div class="tablecol"><a href="adminOrders.php">Orders</a></div>
        </div>
        <div class="tablrow">
            <div class="tablecol"><img src="../assets/images/products.png"></div>
            <div class="tablecol"><a href="adminProducts.php">Products</a></div>
        </div>
    </div>

    <div class="rgtcontent2">
        <div class="ttbl4">
            <h3>Product List</h3>
            <table class="tbl4">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Old Price</th>
                    <th>Special Price</th>
                    <th>Discount</th>
                    <th>Status</th>
                    <th>Date Added</th>
                    <th>Rating</th>
                </tr>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product['ImageURL']): ?>
                            <img src="../<?= $product['ImageURL'] ?>" width="50" height="50">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?= $product['ProductName'] ?></td>
                    <td><?= $product['Brand'] ?></td>
                    <td><?= $product['Category'] ?></td>
                    <td><?= $product['SupplierID'] ?></td>
                    <td><?= $product['QuantityInStock'] ?></td>
                    <td><?= $product['OldPrice'] ?> DT</td>
                    <td><?= $product['SpecialPrice'] ?> DT</td>
                    <td><?= $product['Discount'] ?>%</td>
                    <td><?= $product['Status'] ?></td>
                    <td><?= $product['DateAdded'] ?></td>
                    <td><?= $product['Rating'] ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="tbl3">
            <h3>Add New Product</h3>
            <form method="POST" action="" enctype="multipart/form-data">
                <label>Product Name:</label><input type="text" name="name" required><br>
                <label>Description:</label><input type="text" name="description"><br>
                <label>Category:</label><input type="text" name="category"><br>
                <label>Brand:</label><input type="text" name="brand"><br>
                <label>Supplier ID:</label><input type="text" name="supplier"><br>
                <label>Old Price:</label><input type="number" step="0.01" name="old_price" required><br>
                <label>Special Price:</label><input type="number" step="0.01" name="special_price"><br>
                <label>Quantity in Stock:</label><input type="number" name="quantity" required><br>
                <label>Discount (%):</label><input type="number" step="0.01" name="discount"><br>
                <label>Upload Image:</label><input type="file" name="image"><br>
                <label>Status:</label><input type="text" name="status" value="Available"><br>
                <label>Rating:</label><input type="number" step="0.01" name="rating" max="5"><br><br>
                <button type="submit" name="add_product" class="submit-btn">Add Product</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>