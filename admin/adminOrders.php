<?php
include "../includes/database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/GlowUpBeauty.svg" type="image/icon type">
    <title>Admin Orders - GlowUpBeauty</title>
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
                <h3>Latest Orders</h3>
                <table class="tbl4">
                    <tr>
                        <th>Client</th>
                        <th>Order ID</th>
                        <th>Date & Time</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $stmt = $connect->query("SELECT O.OrderID, O.OrderDate, O.TotalAmount, O.OrderStatus, C.FirstName, C.LastName
                                             FROM Orders O
                                             JOIN Clients C ON O.ClientID = C.ClientID
                                             ORDER BY O.OrderDate DESC");

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['FirstName']) . " " . htmlspecialchars($row['LastName']) . "</td>";
                        echo "<td>" . $row['OrderID'] . "</td>";
                        echo "<td>" . $row['OrderDate'] . "</td>";
                        echo "<td>" . $row['TotalAmount'] . " VND</td>";
                        echo "<td><div class='stat'>" . htmlspecialchars($row['OrderStatus']) . "</div></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>