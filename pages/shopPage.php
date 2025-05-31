<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowUpBeauty</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/GlowUpBeauty.svg" type="image/icon type">
    <script src="../assets/js/scripts.js"></script>
</head>

<body>

<?php include "../includes/header.php"; ?>
<section class="container main-shop">
    <!-- Filter Sidebar -->
    <div class="filters-card">
        <div style="display:flex;justify-content:space-between;">
            <h2 class="fliter-text">Filters</h2>
            <img src="../assets/images/filter.svg">
        </div>
        <hr>
        <form method="GET" action="shopPage.php">
            <!-- Brand Filter -->
            <h2 class="fliter-text">Brands</h2>
            <hr>
            <div class="filter-detail">
                <?php
                include_once "../includes/database.php";
                $query = "SELECT DISTINCT Brand FROM Product WHERE Brand != 'Intel'";
                $stmt = $connect->prepare($query);
                $stmt->execute();
                $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($brands as $brand) {
                    $checked = (!empty($_GET['brand']) && in_array($brand['Brand'], $_GET['brand'])) ? "checked" : "";
                    echo "<label class='main'>{$brand['Brand']}
                            <input type='checkbox' name='brand[]' value='{$brand['Brand']}' $checked>
                            <span class='checkbox-container'></span>
                          </label>";
                }
                ?>
            </div>

            <!-- Category Filter -->
            <h2 class="fliter-text">Categories</h2>
            <hr>
            <div class="filter-detail">
                <?php
                $query = "SELECT DISTINCT Category FROM Product";
                $stmt = $connect->prepare($query);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                    $checked = (!empty($_GET['category']) && in_array($category['Category'], $_GET['category'])) ? "checked" : "";
                    echo "<label class='main'>{$category['Category']}
                            <input type='checkbox' name='category[]' value='{$category['Category']}' $checked>
                            <span class='checkbox-container'></span>
                          </label>";
                }
                ?>
            </div>

            <hr>
            <div style="display: flex; gap: 10px;">
                <input class="filter-btn" value="Apply filters" type="submit">
                <a href="shopPage.php" class="filter-btn" style="text-align:center; line-height: 35px; background-color: #ccc; color: black; text-decoration: none;">Clear filters</a>
            </div>
        </form>
    </div>

    <!-- Shop Products -->
    <div class="shop-right">
        <div class="shop-products-list">
            <div class="search">
                <!-- Search bar -->
                <form method="GET" action="shopPage.php" class="search-form" style="margin-bottom: 20px;">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit">Search</button>
                </form>
            </div>
            <ul>
                <?php include "../loaders/shopProductLoader.php"; ?>
            </ul>
        </div>
        <hr style="width: 90%;">

        <!-- Pages footer -->
        <div class="page-footer">
            <!-- Previous button -->
            <?php
            $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
            $prevPage = ($page > 1) ? $page - 1 : 1;
            $queryString = $_GET;
            $queryString['page'] = $prevPage;
            echo "<a class='btn-p' href='shopPage.php?" . http_build_query($queryString) . "'>";
            ?>
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1dvw">
                <img src="../assets/images/left-arrow.svg"><div>Previous</div>
            </div>
            </a>

            <!-- Page Numbers -->
            <?php
            $prod_per_page = 16;
            $sql = "SELECT COUNT(ProductID) AS total FROM product";
            $stm = $connect->query($sql);
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $total_pages = ceil($row["total"] / $prod_per_page);
            ?>
            <div class="pages">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    $queryString['page'] = $i;
                    $class = ($i == $page) ? "curPage" : "nrml-page";
                    echo "<a href='shopPage.php?" . http_build_query($queryString) . "'><div class='$class'>$i</div></a> ";
                }
                ?>
            </div>

            <?php
            $nextPage = ($page < $total_pages) ? $page + 1 : $total_pages;
            $queryString['page'] = $nextPage;
            echo "<a class='btn-p' href='shopPage.php?" . http_build_query($queryString) . "'>";
            ?>
            <div style="display:flex;justify-content:space-between;align-items:center;gap:1dvw">
                <div>Next</div><img src="../assets/images/right-arrow.svg">
            </div>
            </a>
        </div>
    </div>
</section>

<?php include "../includes/footer.php"; ?>
</body>
</html>
