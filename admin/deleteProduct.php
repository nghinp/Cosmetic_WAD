<?php
session_start();
include "../includes/database.php";

// Admin protection
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../config/login.php");
    exit();
}

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

    // Redirect to admin panel
    header("Location: adminProducts.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

