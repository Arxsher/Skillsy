<?php
session_start();
include "mydb.php";

$showLoginModal = false;

if (!empty($_SESSION['error'])) {
    $showLoginModal = true;
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION["userName"])) {
    header("Location: ../home.php");
    exit();
}

$inscription = "";
if (isset($_SESSION["inscription"])) {
    $inscription = $_SESSION["inscription"];
    unset($_SESSION["inscription"]);
}

$email = $pswrd = "";
$errorEmail = $errorPswrd = "";

function test($inp) {
    $inp = trim($inp);
    $inp = stripslashes($inp);
    $inp = htmlspecialchars($inp, ENT_QUOTES, 'UTF-8');
    return $inp;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["send"])) {
    $valid = true;

    if (empty($_POST["email"])) {
        $_SESSION['errorEmail'] = '* Email is required.';
        $valid = false;
    } else {
        $email = test($_POST["email"]);
    }

    if (empty($_POST["password"])) {
        $_SESSION['errorPswrd'] = '* Password is required.';
        $valid = false;
    } else {
        $pswrd = test($_POST["password"]);
    }

    if (!$valid) {
        $_SESSION['error'] = "* Please fill in all required fields.";
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'login';
        header("Location: ../index.php");
        exit();
    }

    // Now fields are filled, continue with login
    try {
        $stmt = $conn->prepare("SELECT name, userName, pswrd FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($pswrd, $user["pswrd"])) {
                session_regenerate_id(true); // Secure the session
                $_SESSION["userName"] = $user["userName"];
                $_SESSION["name"] = $user["name"];
                unset($_SESSION['error']);
                unset($_SESSION['showLoginModal']);
                unset($_SESSION['activeModalSection']);
                header("Location: ../home.php");
                exit();
            } else {
                $_SESSION['error'] = "The email or password is incorrect.";
                $_SESSION['showLoginModal'] = true;
                $_SESSION['activeModalSection'] = 'login';
            }
        } else {
            $_SESSION['error'] = "This account does not exist.";
            $_SESSION['showLoginModal'] = true;
            $_SESSION['activeModalSection'] = 'login';
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'login';
    }

    header("Location: ../index.php");
    exit();
}
?>
