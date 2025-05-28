<?php 
if (
    isset($_POST["firstname"]) && 
    isset($_POST["lastname"]) && 
    isset($_POST["phone"]) && 
    isset($_POST["email"]) && 
    isset($_POST["password"]) && 
    isset($_POST["confirmpassword"]) && 
    $_POST["password"] === $_POST["confirmpassword"]
) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $phonenumber = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"]; 
    $address = $_POST["address"];

    include "../includes/database.php";

    $stmt = $connect->prepare("SELECT * FROM clients WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        echo "<script>alert('A user with this email already exists.'); window.location.href = '../pages/SignUpPage.php';</script>";
        exit();
    } else {
        $stmt = $connect->prepare("
            INSERT INTO clients (FirstName, LastName, Email, Password, Address, PhoneNumber)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $firstname,
            $lastname,
            $email,
            $password, 
            $address,
            $phonenumber
        ]);

        echo "<script>alert('Account created successfully!'); window.location.href='../pages/signinPage.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Missing or mismatched fields. Please try again.'); window.location.href='../pages/SignUpPage.php';</script>";
    exit();
}
