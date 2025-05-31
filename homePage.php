<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowUpBeauty</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="assets/images/GlowUpBeauty.svg" type="image/icon type">
    <script src="assets/js/scripts.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <div class="left">
            <div class="logo"><img src="assets/images/GlowUpBeauty.svg" alt="logo" height="60px" /></div>
            <nav>
                <ul>
                    <li><a href="homePage.php">Home</a></li>
                    <li><a href="pages/shopPage.php">Shop</a></li>
                    <li><a href="pages/brandsPage.php">Brands</a></li>
                </ul>
            </nav>
        </div>
        <div class="icons">
            <div class="icon"><a href="config/login.php"><img src="assets/images/profile.svg" height="25px" /></a></div>
            <div class="icon"><a href="pages/cartPage.php"><img src="assets/images/cart.svg" height="25px" /></a></div>
        </div>
    </header>
    <!-- ---------------------------------------------------------------------------------------------------- -->

    <!-- Hero section -->
    <section class="hero-section">
        <div class="hero-left">
            <h1 class="hero-text"> <br>UNVEIL YOUR </br>INNER SHINE</h1>
            <button class="shop-btn"><a href="pages/shopPage.php">Shop Now</a></button>
        </div>
    </section>
    <!-- ------------------------------------------------------------------------------------------------------------------- -->

    <!-- Stats Section -->
    <section class="stats-section">
        <div>
            <p><span class="numbers" id="counter1"></span><span class="desc-number"><br>International Brands</span></p>
        </div>
        <div class="mid">
            <p><span class="numbers" id="counter2"></span><span class="desc-number"><br>High-Quality Products</span></p>
        </div>
        <div>
            <p><span class="numbers" id="counter3"></span><span class="desc-number"><br>Happy Customers</span></p>
        </div>
    </section>
    <!-- ---------------------------------------------------------------------------------------------- -->



    <!-- Most selled Products section -->
    <section class="container">
        <div class="title">
            <h1 class="title-text">MOST SELLED PRODUCTS</h1>
        </div>
        <div class="products-list">
            <ul>
                <?php
                require_once "includes/database.php";

                $quer = "SELECT * FROM product WHERE ProductID IN (4,18,80,150,76)";
                $stm = $connect->query($quer);
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    $url = $row["ImageURL"]; ?>
                    <!-- displaying product card -->
                    <li><a href="pages/productDetailPage.php?ID=<?php echo "$row[ProductID]" ?>">
                            <div class="product-item">
                                <div><img src="<?php echo $url ?>" alt="product" class="prd-img" /></div>
                                <p class="pr-name"><?php echo $row["ProductName"] ?></p>
                                <img src="assets/images/rating.svg" alt="rating">
                                <p class="pr-price"><?php echo $row["OldPrice"] ?> DT</p>
                            </div>
                        </a></li>

                <?php } ?>


            </ul>
        </div>

        <div class="btn-div">
            <button class="btn"><a href="pages/shopPage.php">View All</a></button>

        </div>
    </section>
    <!-- ------------------------------------------------------------------------------------------------------------ -->
    <!-- Feedbacks section -->
    <hr style="width: 90%;">
    <section class="container">
        <div class="title">
            <h1 class="title-text">OUR HAPPY COSTUMERS</h1>
        </div>
        <div class="Feedbacks">
            <ul>
                <li>
                    <div class="feedback">
                        <div><img src="assets/images/rating.png" alt="rating" /></div>
                        <div style="display: flex;align-items: center;">
                            <h3>Phuong Nghi</h3>
                            <img src="assets/images/check.svg" alt="" height="20px" />
                        </div>
                        <p>"The user-friendly layout, gave me the confidence to select the right cosmetics for my skin tone."</p>
                    </div>
                </li>
                <li>
                    <div class="feedback">
                        <div><img src="assets/images/rating.png" alt="rating" /></div>
                        <div style="display: flex;align-items: center;">
                            <h3>Taylor Swift</h3>
                            <img src="assets/images/check.svg" alt="" height="20px" />
                        </div>
                        <p>"Shopping for beauty products has never been easier! With a vast selection of high-quality cosmetics."</p>
                    </div>
                </li>
                <li>
                    <div class="feedback">
                        <div><img src="assets/images/rating.png" alt="rating" /></div>
                        <div style="display: flex;align-items: center;">
                            <h3>Mohamed Sala</h3>
                            <img src="assets/images/check.svg" alt="" height="20px" />
                        </div>
                        <p>I've been a loyal customer of GlowUpBeauty for years, and for good reason. Not only does it offer an extensive range of makeup products, but the customer service is also top-notch. I'm in love with GlowUpBeauty”</p>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-item">
                <img src="assets/images/GlowUpBeauty.svg" alt="logo" height="50px" />
                <p>Elevate your beauty routine with precision.<br> Discover premium cosmetics tailored<br> to your skin tone and style. Create your dream<br> look with GlowUpBeauty.</p>
                <div class="socials"><a href="https://github.com/nghinp/Cosmetic_WAD.git"><img src="assets/images/Social.svg" alt="socials" /></a></div>
            </div>
            <div class="footer-item">
                <p class="title">Company</p>
                <ul>
                    <li>About</li>
                    <li>Features</li>
                    <li>Works</li>
                    <li>Career</li>
                </ul>
            </div>
            <div class="footer-item">
                <p class="title">Help</p>
                <ul>
                    <li>Costumer Support</li>
                    <li>Delivery Details</li>
                    <li>Terms & Conditions</li>
                    <li>Privacy Policy</li>
                </ul>
            </div>
            <div class="footer-item">
                <p class="title">FAQ</p>
                <ul>
                    <li>Account</li>
                    <li>Manage Deliveries</li>
                    <li>Orders</li>
                    <li>Payments</li>
                </ul>
            </div>
        </div>
        <hr style="width: 90%;">
        <div class="flex-items">
            <p class="copyrights">Shop.co © 2025, All Rights Reserved</p>
            <div class="flex">
                <img src="assets/images/visa.svg" alt="visa" />
            </div>
        </div>
    </footer>

</body>

</html>