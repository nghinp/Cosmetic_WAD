<?php 
include_once "../includes/database.php";

$prod_per_page = 16;
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
$start_from = ($page - 1) * $prod_per_page;

// Initialize base SQL
$sql = "SELECT * FROM product WHERE 1=1";

// Filter: Brands
if (!empty($_GET['brand'])) {
    $brands = $_GET['brand'];
    $placeholders = implode(',', array_fill(0, count($brands), '?'));
    $sql .= " AND Brand IN ($placeholders)";
}

// Filter: Categories
if (!empty($_GET['category'])) {
    $categories = $_GET['category'];
    $placeholders2 = implode(',', array_fill(0, count($categories), '?'));
    $sql .= " AND Category IN ($placeholders2)";
}

// Add pagination
$sql .= " LIMIT $start_from, $prod_per_page";

// Prepare & bind
$stmt = $connect->prepare($sql);

// Merge parameters in the right order
$params = [];
if (!empty($_GET['brand'])) $params = array_merge($params, $brands);
if (!empty($_GET['category'])) $params = array_merge($params, $categories);

// Execute
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output products
foreach ($result as $row) {
    $url = $row["ImageURL"]; ?>
    <li>
        <a href="../pages/productDetailPage.php?ID=<?php echo $row["ProductID"]; ?>">
            <div class="product-item">
                <div><img src="../<?php echo htmlspecialchars($row['ImageURL']); ?>" alt="product" style="width:100%; height:auto;"></div>
                <p class="pr-name"><?php echo $row["ProductName"]; ?></p>
                <img src="../assets/images/rating.svg" alt="rating">
                <p class="pr-price"><?php echo $row["OldPrice"]; ?> DT</p>  
            </div>
        </a>
    </li>
<?php } ?>
