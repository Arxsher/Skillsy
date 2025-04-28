<?php
include "mydb.php";
session_start();

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
    
    // Validate name
    if (empty($_POST["name"])) {
        $errorName = '*Name is required.';
        $valid = false;
    } else {
        $name = test($_POST["name"]);
    }
    
    // Validate username
    if (empty($_POST["userName"])) {
        $errorUserName = '*User Name is required.';
        $valid = false;
    } else {
        $userName = test($_POST["userName"]);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $errorEmail = '*Email is required.';
        $valid = false;
    } else if (!isValidEmail($_POST["email"])) {
        $errorEmail = "Invalid Email";
        $valid = false;
    } else {
        $email = test($_POST["email"]);
    }
    
    // Validate password
    if (empty($_POST["password"])) {
        $errorPswrd = '*Password is required.';
        $valid = false;
    } elseif (!isValidPassword($_POST["password"])) {
        $errorPswrd = '*At least 8 chars, one uppercase, one lowercase, one number';
        $valid = false;
    } else {
        $pswrd = test($_POST["password"]);
    }

    if (!$valid) {
        // Store errors in session to display after redirect
        $_SESSION['errorName'] = $errorName;
        $_SESSION['errorUserName'] = $errorUserName;
        $_SESSION['errorEmail'] = $errorEmail;
        $_SESSION['errorPswrd'] = $errorPswrd;
        
        // Only set showStep2 if we have username and email but missing name
        // This means user is already on step 2
        if (!empty($errorName) && empty($errorUserName) && empty($errorEmail)) {
            // Error in step 2 (name field is in step 2)
            $_SESSION['showStep2'] = true;
        } else {
            // Keep on step 1 for username/email errors
            $_SESSION['showStep2'] = false;
        }
        
        $_SESSION['error'] = "Please fill in all required fields correctly.";
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'signup';
        header("Location: ../index.php");
        exit();
    }

    // All fields are valid, proceed with registration
    $hashedPassword = password_hash($pswrd, PASSWORD_DEFAULT);
    try {
        $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);

        $checkUserName = $conn->prepare("SELECT id FROM users WHERE userName = ?");
        $checkUserName->execute([$userName]);

        if ($checkEmail->rowCount() > 0) {
            $_SESSION['error'] = "Email already associated with an account. Please try again.";
            $_SESSION['showLoginModal'] = true;
            $_SESSION['activeModalSection'] = 'signup';
            header("Location: ../index.php");
            exit();
        } else if ($checkUserName->rowCount() > 0) {
            $_SESSION['error'] = "User Name already taken. Please try again.";
            $_SESSION['showLoginModal'] = true;
            $_SESSION['activeModalSection'] = 'signup';
            header("Location: ../index.php");
            exit();
        } else {
            $stmt = $conn->prepare("INSERT INTO users (name, userName, email, pswrd) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $userName, $email, $hashedPassword])) {
                $_SESSION["inscription"] = "Account successfully created. Please log in";
                // Set a flag to show the login form after redirect
                $_SESSION["showLoginForm"] = true;
                $_SESSION["showLoginModal"] = true;
                header("Location: ../index.php");
                exit();
            } else {
                $_SESSION['error'] = "There is an error in the registration.";
                $_SESSION['showLoginModal'] = true;
                $_SESSION['activeModalSection'] = 'signup';
                header("Location: ../index.php");
                exit();
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        $_SESSION['showLoginModal'] = true;
        $_SESSION['activeModalSection'] = 'signup';
        header("Location: ../index.php");
        exit();
    }
}

?>
