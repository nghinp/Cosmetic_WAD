<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GlowUpBeauty</title>
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/style1.css">
        <link rel="icon" href="../assets/images/GlowUpBeauty.svg" type="image/icon type">
    </head>
    <body>
        <!-- Header -->
        <?php include "../includes/header.php" ?>
        <section class="pr-main container">
            <?php 
                include "../includes/database.php" ;
                session_start();

                if (isset($_GET["ID"]) && is_numeric($_GET['ID'])){
                    $id = htmlspecialchars($_GET['ID']);
                    
                    $sql = "SELECT * FROM product WHERE ProductID = ?";
                    $stm = $connect->prepare($sql);
                    $stm->execute([$id]);

                    
                    $product = $stm->fetch(PDO::FETCH_ASSOC);
                }
            ?>
            <div class="product-detail-img">
                <img src="../<?php echo htmlspecialchars($product['ImageURL']); ?>" alt="product" style="max-width:60%; height:auto;">
            </div>
            <div class="product-info">
                <h1 class="pr-name"><?php echo $product['ProductName'] ?></h1>
                <div class="rate">
                    <img src="../assets/images/rating.svg" alt="" style="margin-right:30px;">
                    <div><?php echo $product['Rating']?></div>
                </div>

                <div class="pr-detail-price">
                    <?php
                    if ($product['SpecialPrice']!=0){
                            echo "<div style='display:flex'>";
                            echo"<div class='price-d'>".$product["SpecialPrice"]." VND</div>";
                            echo "<div class='price-bd'>".$product['OldPrice']." VND</div>";
                            echo"<div class='discount'><p>".$product['Discount']." VND</p></div>" ;
                            echo "</div>";
                        } else echo "<div class='price-d'>".$product['OldPrice']." VND</div>";
                    
                    ?>
                </div>
                
                    <p class="product-description"><?php echo $product['Description'] ?></p>
                
                <hr>
                <div class="bot">
                    <div class="quantiy">
                        <button onclick="decreaseQuantity('Q') ;decreaseQuantity('realQ')">-</button>
                        <form action="../config/cartManagement.php" method='POST'>
                            <input type="text" id="Q" name="quantity" value="1" min="1" />
                            <input type="hidden" name="qua" value="1" min="1" />
                        </form>
                        <button onclick="increaseQuantity('Q') ;increaseQuantity('realQ')">+</button>
                    </div>
                    <form action="../config/cartManagement.php" method='POST'>
                        <input class="add-cart-btn" type="submit" name="add_to_cart" value="Add to Cart"/>
                        <input type="hidden" name='q' value="1" id="realQ">
                        <input type="hidden" name='productID' value="<?php echo $product['ProductID'] ?>">
                    </form>
                </div>
            </div>
        </section>
                        
        <?php 
            if (isset($_POST['quantity'])) echo "quantity set" ;
        ?>
        

        <?php include "../includes/footer.php" ?>
        <script src="../assets/js/script2.js"></script>
</body>
</html>