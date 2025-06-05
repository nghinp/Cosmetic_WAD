<?php
include_once "../includes/database.php";

$prod_per_page = 16;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$start_from = ($page - 1) * $prod_per_page;  //only show product from that page

$sql = "SELECT * FROM product WHERE 1=1";
$params = []; //empty box where store the filters (brand, category, search…)

// Brand Filter
if (!empty($_GET['brand'])) {
    $brands = $_GET['brand'];
    $placeholders = implode(',', array_fill(0, count($brands), '?'));
    $sql .= " AND Brand IN ($placeholders)";
    $params = array_merge($params, $brands);
}

// Category Filter
if (!empty($_GET['category'])) {
    $categories = $_GET['category'];
    $placeholders2 = implode(',', array_fill(0, count($categories), '?'));
    $sql .= " AND Category IN ($placeholders2)";
    $params = array_merge($params, $categories);
}

// Search Filter
if (!empty($_GET['search'])) {
    $sql .= " AND ProductName LIKE ?";
    $params[] = "%" . trim($_GET['search']) . "%";
}

// Pagination
$sql .= " LIMIT $start_from, $prod_per_page";

$stmt = $connect->prepare($sql);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display
foreach ($result as $row) {
    ?>
    <li>
        <a href="../pages/productDetailPage.php?ID=<?php echo $row["ProductID"]; ?>">
            <div class="product-item">
                <div><img src="../<?php echo htmlspecialchars($row['ImageURL']); ?>" alt="product" style="width:100%; height:auto;"></div>
                <p class="pr-name"><?php echo $row["ProductName"]; ?></p>
                <img src="../assets/images/rating.svg" alt="rating">
                <p class="pr-price"><?php echo $row["OldPrice"]; ?> VND</p>  
            </div>
        </a>
    </li>
    <?php
}
?>
