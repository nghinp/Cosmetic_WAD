<?php
include "../includes/database.php";

// Total Orders
$totalOrdersStmt = $connect->query("SELECT COUNT(*) AS totalOrders FROM Orders");
$totalOrders = $totalOrdersStmt->fetch(PDO::FETCH_ASSOC)['totalOrders'];

// Top Brands
$brandStmt = $connect->query("
    SELECT P.Brand, COUNT(*) AS Count
    FROM OrderDetail OD
    JOIN Product P ON OD.ProductID = P.ProductID
    GROUP BY P.Brand
    ORDER BY Count DESC
    LIMIT 5
");
$topBrands = $brandStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/GlowUpBeauty.svg" type="image/icon type">
    <title>Admin Dashboard</title>
</head>
<body>
    <nav>
    <div><img src="../assets/images/GlowUpBeauty.svg" class="logo" height="40px"/></div>
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
                <h2>Admin Dashboard</h2>
                <div style="margin-top: 20px;">
                    <h3>Total Orders: <?php echo $totalOrders; ?></h3>
                </div>

                <div style="margin-top: 30px;">
                    <h3>Top 5 Brands Ordered:</h3>
                    <ul>
                        <?php foreach ($topBrands as $brand): ?>
                            <li><?php echo htmlspecialchars($brand['Brand']); ?> (<?php echo $brand['Count']; ?> orders)</li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
