<?php
session_start();
include "../includes/database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$id = $_GET['id'];

try {
    // Delete related rows in orderdetail table
    $deleteDetails = $connect->prepare("DELETE FROM orderdetail WHERE ProductID = ?");
    $deleteDetails->execute([$id]);

    // Delete the product itself
    $deleteProduct = $connect->prepare("DELETE FROM product WHERE ProductID = ?");
    $deleteProduct->execute([$id]);

    header("Location: adminProducts.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

