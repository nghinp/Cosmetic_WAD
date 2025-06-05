<?php
include "../includes/database.php";

// selecting all orders for the current user
$sql = "SELECT * FROM Orders WHERE ClientID = ?";
$stm = $connect->prepare($sql);
$stm->execute([$_SESSION['ClientID']]);
$orders = $stm->fetchAll(PDO::FETCH_ASSOC);

foreach ($orders as $order) {
    // select all products from this order
    $query = "SELECT P.ProductName, P.ImageURl, OD.Subtotal, OD.Quantity 
              FROM OrderDetail AS OD 
              JOIN Product AS P ON P.ProductID = OD.ProductID 
              WHERE OD.OrderID = ?";
    $stt = $connect->prepare($query);
    $stt->execute([$order['OrderID']]);
    $products = $stt->fetchAll(PDO::FETCH_ASSOC);

    if (count($products) > 0) {
        foreach ($products as $product) {
            ?>
            <tr>
                <td><?php echo $product['ProductName']; ?></td>
                <td><?php echo $product['Quantity']; ?></td>
                <td><?php echo $product['Subtotal']; ?> VND</td>
                <td><?php echo $order['OrderDate']; ?></td>
                <td><?php echo $order['OrderStatus']; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr class="line">
    <td><strong>Total :</strong></td>
    <td colspan="5S"><strong><?php echo $order['TotalAmount']; ?> VND</strong></td>
</tr>

        <?php
    }
}
?>
