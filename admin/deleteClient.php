<?php
session_start();
include "../includes/database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid client ID.");
}

$id = $_GET['id'];

try {
    // Delete related orders (if foreign key exists)
    $connect->prepare("DELETE FROM orders WHERE ClientID = ?")->execute([$id]);

    // Then delete the client
    $connect->prepare("DELETE FROM clients WHERE ClientID = ?")->execute([$id]);

    header("Location: adminCustomers.php");
    exit();
} catch (PDOException $e) {
    echo "Error deleting client: " . $e->getMessage();
}
?>
