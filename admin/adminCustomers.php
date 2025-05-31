<?php
session_start();
include "../includes/database.php";

// Optional: Only allow admin access
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../config/login.php");
    exit();
}

// Fetch all clients
$query = "SELECT * FROM clients";
$stmt = $connect->prepare($query);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - </title>
</head>

<body>
    <nav>
        <div><img src="../assets/images/GlowUpBeauty.svg" class="logo" height="40px" /></div>
        <div class="logout-container">
           <a href="../config/logout.php" class="logout-btn">Logout</a>
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
                <div class="tablecol"><a href="adminCustomers.php">Customers</a></div>
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
                <h3>Customer List</h3>
                <table class="tbl4">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars($client['ClientID']) ?></td>
                            <td><?= htmlspecialchars($client['FirstName']) ?></td>
                            <td><?= htmlspecialchars($client['LastName']) ?></td>
                            <td><?= htmlspecialchars($client['Email']) ?></td>
                            <td><?= htmlspecialchars($client['PhoneNumber']) ?></td>
                            <td><?= htmlspecialchars($client['Address']) ?></td>
                            <td>
                                <a href="deleteClient.php?id=<?= $client['ClientID'] ?>" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>