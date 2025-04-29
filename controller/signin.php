<?php
// require
require_once __DIR__ . '/../model/mydb.php';
// session
session_start();

$showLoginModal = false;

if (!empty($_SESSION['error'])) {
    $showLoginModal = true;
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION["userName"])) {
    header("Location: ../view/home.php");
    exit();
}

$name = $userName = $email = $pswrd =  "";
$errorName = $errorUserName = $errorEmail = $errorPswrd = "";
$alert = $inscription = $error = "";

function test($inp)
{
    $inp = trim($inp);
    $inp = stripslashes($inp);
    $inp = htmlspecialchars($inp, ENT_QUOTES, 'UTF-8');
    return $inp;
}

function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isValidPassword($password)
{
    return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/", $password);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["signin"])) {
    $valid = true;
    // validate name
    if (empty($_POST["name"])) {
        $errorName = '*Name is required.';
        $valid = false;
    } else {
        $name = test($_POST["name"]);
    }
    // validate username
    if (empty($_POST["userName"])) {
        $errorUserName = '*User Name is required.';
        $valid = false;
    } else {
        $userName = test($_POST["userName"]);
    }
    // validate email
    if (empty($_POST["email"])) {
        $errorEmail = '*Email is required.';
        $valid = false;
    } else if (!isValidEmail($_POST["email"])) {
        $errorEmail = "Invalid Email";
        $valid = false;
    } else {
        $email = test($_POST["email"]);
    }
    // validate password
    if (empty($_POST["password"])) {
        $errorPswrd = '*Password is required.';
        $valid = false;
    } elseif (!isValidPassword($_POST["password"])) {
        $errorPswrd = '*At least 8 chars, one uppercase, one lowercase, one number';
        $valid = false;
    } else {
        $pswrd = test($_POST["password"]);
    }
    // error handling
    if (!$valid) {
        $_SESSION['errorName'] = $errorName;
        $_SESSION['errorUserName'] = $errorUserName;
        $_SESSION['errorEmail'] = $errorEmail;
        $_SESSION['errorPswrd'] = $errorPswrd;
        if (!empty($errorName) && empty($errorUserName) && empty($errorEmail)) {
            $_SESSION['showStep2'] = true;
        } else {
            $_SESSION['showStep2'] = false;
        }
        $_SESSION['error'] = "Please fill in all required fields correctly.";
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'signup';
        header("Location: ../view/index.php");
        exit();
    }
    // hash password
    $hashedPassword = password_hash($pswrd, PASSWORD_DEFAULT);
    // registration
    try {
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        $checkUserName = $conn->prepare("SELECT id FROM users WHERE userName = ?");
        $checkUserName->execute([$userName]);
        if ($checkEmail->rowCount() > 0) {
            $_SESSION['error'] = "Email already associated with an account. Please try again.";
            $_SESSION['showLoginModal'] = true;
            $_SESSION['activeModalSection'] = 'signup';
            header("Location: ../view/index.php");
            exit();
        } else if ($checkUserName->rowCount() > 0) {
            $_SESSION['error'] = "User Name already taken. Please try again.";
            $_SESSION['showLoginModal'] = true;
            $_SESSION['activeModalSection'] = 'signup';
            header("Location: ../view/index.php");
            exit();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, userName, email, pswrd) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $userName, $email, $hashedPassword])) {
                $_SESSION["inscription"] = "Account successfully created. Please log in";
                $_SESSION["showLoginForm"] = true;
                $_SESSION["showLoginModal"] = true;
                header("Location: ../view/index.php");
                exit();
            } else {
                $_SESSION['error'] = "There is an error in the registration.";
                $_SESSION['showLoginModal'] = true;
                $_SESSION['activeModalSection'] = 'signup';
                header("Location: ../view/index.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'signup';
        header("Location: ../view/index.php");
        exit();
    }
}
?>
