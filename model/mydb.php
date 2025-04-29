<?php
$dsn = "mysql:host=localhost;dbname=registration";
$user = "root";
$password = "";


try {
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "connected";
} catch (PDOException $e) {
    die("error" . $e->getMessage());
}
?>
