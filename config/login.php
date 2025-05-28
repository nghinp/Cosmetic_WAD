<?php
include '../includes/database.php';
session_start();

if (isset($_SESSION["userFname"]) || isset($_SESSION["is_admin"])) {
    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] === true) {
        header('Location: ../admin/adminOrders.php');
    } else {
        header('Location: ../pages/profilePage.php');
    }
    exit();
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin login
    if ($email === "admin@example.com") {
        $stmt = $connect->prepare("SELECT * FROM admin WHERE Username = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['Password']) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['username'] = $admin['Username'];
            $_SESSION['is_admin'] = true;
            header('Location: ../admin/adminDashboard.php');
            exit();
        } else {
            echo "<script>alert('Invalid admin credentials'); window.location.href='../pages/signinPage.php';</script>";
            exit();
        }
    }

    // Client login
    $stmt = $connect->prepare("SELECT * FROM clients WHERE Email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['Password']) {
        $_SESSION["userFname"] = $user['FirstName'];
        $_SESSION["userLname"] = $user['LastName'];
        $_SESSION["eimail"] = $user['Email'];
        $_SESSION["phone"] = $user['PhoneNumber'];
        $_SESSION["address"] = $user['Address'];
        $_SESSION["ClientID"] = $user['ClientID'];
        header('Location: ../pages/profilePage.php');
        exit();
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='../pages/signinPage.php';</script>";
        exit();
    }
} else {
    header('Location: ../pages/signinPage.php');
    exit();
}
