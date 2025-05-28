    <?php

$host = 'localhost' ;
$dbname = 'setupsprint_ecommerce_website';
$username = 'root';
$password = 'nghi112';

try {
    $connect = new PDO(
        "mysql:host=$host;
        port=8000; 
        dbname=$dbname",
        $username, 
        $password
    );
    
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

