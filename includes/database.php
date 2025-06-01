    <?php

$host = 'localhost' ;
$dbname = 'setupsprint_ecommerce_website';
$username = 'root'; //add your username
$password = 'nghi112'; //add your password

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

